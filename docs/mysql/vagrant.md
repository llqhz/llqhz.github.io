### 环境搭建

```sh
# 查找homestead下载目录
find ./ -type d -name 'homestead'
mac_files/apps/homestead

# 拷贝新的box
cp lc-homestead-8.2.1-2019112300 lc-homestead-dev
vim lc-homestead-dev/metadata.json
"name": "lc/homestead2",

```

查找homestead+box下载的目录

```sh
find ./ -type d -name 'homestead'
mac_files/apps/homestead
```

拷贝新的box, 修改metadata.json里面的name

```sh
cp lc-homestead-8.2.1-2019112300 lc-homestead-dev
vim lc-homestead-dev/metadata.json
```

```json
{
    "name": "lc/homestead2",
    "versions":
    [
        {
            "version": "8.2.1",
            "providers": [
                {
                  "name": "virtualbox",
                  "url": "virtualbox.box"
                }
            ]
        }
    ]
}
```

拷贝Homestead-git目录

```sh
cp -R ~/Homestead Homestead2
```

编辑配置

```yaml
---
name: "homestead-72"
box: "lc/homestead2"
hostname: "homestead2"
ip: "192.168.10.12"
default_ssh_port: 2223

ports:
    - send: 8001
      to: 80
    - send: 44301
      to: 443
    - send: 33061
      to: 3306
    - send: 4041
      to: 4040
    - send: 54321
      to: 5432
    - send: 8026
      to: 8025
    - send: 27018
      to: 27017
```

完整配置文件

```yaml
---
name: "homestead-72"
box: "lc/homestead2"
hostname: "homestead2"
ip: "192.168.10.12"
memory: 2048
cpus: 1
provider: virtualbox
default_ssh_port: 2223

authorize: ~/.ssh/id_rsa.pub

keys:
    - ~/.ssh/id_rsa

folders:
    - map: ~/code
      to: /home/vagrant/code

sites:
    - map: homestead2.test
      to: /home/vagrant/code/public

databases:
    - homestead

# blackfire:
#     - id: foo
#       token: bar
#       client-id: foo
#       client-token: bar

ports:
    - send: 8001
      to: 80
    - send: 44301
      to: 443
    - send: 33061
      to: 3306
    - send: 4041
      to: 4040
    - send: 54321
      to: 5432
    - send: 8026
      to: 8025
    - send: 27018
      to: 27017
#    - send: 2223
#      to: 22
#    - send: 7777
#      to: 777
#      protocol: udp
```

启动

```sh
vagrant up
```

### 同步实践

主服务器配置

```ini
vim /etc/mysql/mysql.conf.d/mysqld.cnf

# [mysqld]
server-id               = 1
log_bin                 = /var/log/mysql/mysql-bin.log
binlog_format           = ROW
max_binlog_size         = 100M
binlog_do_db            = master_slave
```

从服务器配置

```ini
server-id=2
relay-log=/var/log/mysql/mysql-relay-bin.log
replicate-do-db=master_slave
```

配置从服务器uuid

```sh
vim /var/lib/mysql/auto.cnf

[auto]
server-uuid=0a797b89-e2b8-11e9-b942-0800279ee528

# 重启自动生成
rm -rf /var/lib/mysql/auto.cnf
```

主从都重启

```sh
mkdir -p /var/run/mysqld && chmod 777 /var/run/mysqld
/usr/sbin/mysqld --daemonize --pid-file=/run/mysqld/mysqld.pid
```

主库创建数据库和表

```sql
create database master_slave default charset=utf8;

use master_slave;

create table student (
	id bigint unsigned not null primary key auto_increment,
    name char(10) not null default '',
    age tinyint unsigned not null default 0,
    address varchar(128) not null default '',
    key s_name (name)
) engine=innodb default charset=utf8;
```

生成测试数据

```sql
insert into student (name,age,address) values ('a', 10, 'xa'),('b', 20, 'xb'),('c', 15, 'xc'),('d', 13, 'xd');

mysql> select * from student;
+----+------+-----+---------+
| id | name | age | address |
+----+------+-----+---------+
|  1 | a    |  10 | xa      |
|  2 | b    |  20 | xb      |
|  3 | c    |  15 | xc      |
|  4 | d    |  13 | xd      |
+----+------+-----+---------+
4 rows in set (0.00 sec)
```

创建同步账号

```sql
create user slave_01@'%' identified by '123456';
grant replication slave on *.* to slave_01@'%'
```

导出主库数据

```sh
mysqldump --single-transaction -uroot --routines --triggers --events --master-data=2 master_slave > master.sql
```

创建数据库并恢复从库数据

```sh
mysql> create database master_slave default charset=utf8;

mysql --database=master_slave < ~/code/learn/mysql/master.sql
```

测试连接主库

```sh
mysql -uslave_01 -p123456 -h192.168.20.11 -P3306
```

配置同步主库

```sql
# master_log_file和master_log_pos 从备份的文件master.sql中看: 
change master to 
master_host='192.168.20.11',
master_port=3306,
master_log_file='mysql-bin.000025',
master_log_pos=664;

# 查看配置
show slave status\G

# 启动同步
start slave user='slave_01' password='123456';
```

测试

```sql
insert into student (name,age,address) values ('e', 21, 'xe');
select * from student;

insert into student (name,age,address) values ('d', 22, 'xf');
select * from student;
```

查看

```sql
mysql> show slave status\G
*************************** 1. row ***************************
               Slave_IO_State: Waiting for master to send event
                  Master_Host: 192.168.20.11
                  Master_User: slave_01
                  Master_Port: 3306
                Connect_Retry: 60
              Master_Log_File: mysql-bin.000025
          Read_Master_Log_Pos: 1248
               Relay_Log_File: mysql-relay-bin.000003
                Relay_Log_Pos: 904
        Relay_Master_Log_File: mysql-bin.000025
             Slave_IO_Running: Yes
            Slave_SQL_Running: Yes
              Replicate_Do_DB: master_slave
			 Master_Server_Id: 1
                  Master_UUID: 0a797b89-e2b8-11e9-b942-0800279ee528
             Master_Info_File: /homestead-vg/master/master.info
					SQL_Delay: 0
          SQL_Remaining_Delay: NULL
      Slave_SQL_Running_State: Slave has read all relay log; waiting for more updates
```

```mysql
mysql> show master status;
+------------------+----------+--------------+------------------+-------------------+
| File             | Position | Binlog_Do_DB | Binlog_Ignore_DB | Executed_Gtid_Set |
+------------------+----------+--------------+------------------+-------------------+
| mysql-bin.000025 |     1248 | master_slave |                  |                   |
+------------------+----------+--------------+------------------+-------------------+
```

