
作用
1. 数据备份
2. FTP / SCP
3. 语法坑 sed /awk

章节
1. 变量
2. 函数
3. 文件
4. 文本 grep sed awk
5. 监控 cpu,内存，io告警 / nginx php-fpm
6. mysql
7. 大型脚本


##  2 变量的高级用法

### 2-1 变量替换和测试

#### 2-1-1 变量替换

1. ${name#pattern}  简单删除
2. ${name#pattern}  贪婪删除
3. ${name%pattern}  尾部简单删除
4. ${name%%pattern}  尾部贪婪删除

5. ${name/pattern/replace} 简单替换
6. ${name//pattern/replace} 贪婪替换

```bash
name='i love you, do you love me'

name1=${name#*you}  # 简单删除
name2=${name##*you}  # 贪婪删除

name3=${name%love*}  # 尾部删除
name4=${name%%love*}  # 尾部贪婪删除

name5=${name/you/xiao_ming}  # 替换
name6=${name//you/xiao_ming}  # 贪婪替换

printf '
name:[%s]
{name#*you}:[%s]
{name##*you}:[%s]
{name%%love*}:[%s]
{name%%%%love*}:[%s]
{name/you/xiao_ming}:[%s]
{name//you/xiao_ming}:[%s]
' "${name}" "${name1}" "${name2}" "${name3}" "${name4}" "${name5}" "${name6}"

```

#### 2-1-2 变量测试
```bash
word=${none_set-hello}
echo "word: [${word}]"
```
表示当 `${none_set}` 未定义时，取‘hello’，定义了时就直接取 `${none_set}`

### 2-2 字符串处理

> expr索引从1开始 $索引从0开始

获取字符串的长度

```bash
str='hello world'

len1=${#str}
len2=$(expr length "$str")

echo "length: ${len1} '${len2}'"
```

获取字符列表索引
> expr index str chars

```bash
str='hello world'

sub_index=$(expr index "$str" 'exxx')

echo "sub_index: [${sub_index}]"
```
> 备注: 索引从1开始,sub_strs为字符列表

获取子串的从头开始匹配的长度
> expr match str pattern

```bash
str='hello world'

match_len=$(expr match "$str" '.*wo')

echo "match_len: [${match_len}]"
```

截取子串
1. ${str:position}
2. ${str:position:length}
3. ${str: -position}
4. ${str:(position)}
5. expr substr str position length

```bash
str='hello world'
#    0123...-2-1
substr1=${str:3}
substr2=${str:3:2}
substr3=${str: -3}
substr4=${str:(-3)}
substr5=$(expr substr "$str" 3 2)

echo "[${substr1}] [${substr2}] [${substr3}] [${substr4}] [${substr5}] "
# [lo world] [lo] [rld] [lo world] [ll]
```

### 2-3 命令替换
1. `command`
2. $(command)

```bash
echo "this is `date +%Y` year"
echo "this is $(date +%Y) year"
```

算数运算
3. (( i++ ))
4. sum=$(( 100 + 200 ))
```bash
i=100

(( i++ ))
sum=$(( 200 + i ))
echo "i:[${i}]  sum:[${sum}]"
```

### 2-4 变量类型
1. declare -r 只读变量
2. declare -i 整型变量
3. declare -a 数组变量
4. declare -f 显示函数详情
5. declare -F 显示函数名称
6. declare -x 声明环境变量 (针对该用户的所有终端)
7. 取消声明: 把'-'换为'+' => declare +r 取消只读

```bash
# 只读
num1=0
declare -r num1
num1=2 # 报错,只读 

# 整型
declare -i num2
num2=10+20  # 会进行整数运算
num3=10+20  # 直接字符串处理
echo "int num2:[${num2}], num3:[${num3}]"
# int num2:[30], num3:[10+20]

# 数组
declare -a boys
boys=('tom' 'jam' 'jack' 'body' 'tim' 'dacy')

echo "${boys[@]}"
echo "${boys[@]:3:2}"  # 数组切片
```


### 2-5 数学运算
# 1. expr $num1 operator $num2

# 2. $(( $num1 operator $num2 ))

# > 注: 比较推荐用expr; 计算用$(())

```bash
# expr比较
if [ `expr $num1 = $num2` -eq 1 ]; then
    echo 'true'
fi

# $(()) 计算
num4=$(( num1 + num2 ))
echo $num4
```

### 2-5 bc数学运算
bc是bash内置,支持浮点运算,支持scale设置精度

```bash
num5=`echo "scale=4;37/$num4" | bc`
echo "37/$num4=${num5}"
```


##  3 函数的高级用法

### 3-1 函数介绍

函数定义

```bash
# 定义
fun_name_01()
{
    echo 'fun1'
    return 1  # 表示失败 
}
fun_name_01 && echo 'success' || echo 'failed'

# 调用
function fun_name_02()
{
    echo 'fun2' 
    echo '参数1:' "$1"
    echo '参数2:' "$2"
    echo '参数长度:' "${#}"
    echo '所有参数:' "${@}"
}
fun_name_02 1 2


# 返回
function fun_name_03()
{
    local arr=("001" "002" "003")
    echo "${arr[@]}"
}
for i in $(fun_name_03); do
    echo $i
done
```

> 备注: sh -x xxx.sh 可以展示脚本执行过程



### 3-2 函数作用域

1. 全局变量
2. 局部变量 local

```bash
local a=1 b=2 c
echo ${a} ${b} ${c}
```

### 3-3 函数库

使用 source 或者 . 来引入之前定义好的函数文件

1. 文件后缀 .lib
2. 没有x权限
3. 第一行使用 #!/bin/echo 输出警告信息


## 4 文件相关命令

### 4-1 find命令

语法格式: find path options operation
语法格式: find 路径 选项 操作

选项 -name -iname -type -mtime -mmin -maxdepth
```bash
find /etc/php -name '*.conf'
find /etc/php -iname '*.conf'  # 忽略大小写

# type: d:目录 f:文件 l:链接
find /etc/php/7.4 -user root -group root -type d

# 文件大小 k M G;  +:> -:< 
find /etc -size +100k > /dev/null 2>&1

# 文件修改时间
find /etc/ -mtime -3  # 小于3天
# find /etc/ -mtime +3  # 大于3天

find /etc -mmin -10  # 10min内修改过的文件

# 搜索层级
find /etc -maxdepth 2 -type d -mmin -10
```

操作: -exec command {} \;

```bash
# find /var/log/2020/ -name '2020*.log' -mtime +180 -exec rm -rf {} \; 
```



### 4-2 其他命令

1. locate命令 (索引缓存,每天定时更新) 
updatedb
更新文件: /var/lib/mlocate/mlocate.db
配置文件: /etc/updatedb.conf

2. whereis 命令 
查找二进制文件及其帮助文件

3. which 命令 
查找二进制文件

```bash
# locate 查找
locate php-fpm.conf

# whereis 查找命令可能包含的二进制文件
whereis php-fpm

# which 查找当前命令正在使用的具体二进制文件
which php
```

## 5 文本处理

### 5-1 grep与egrep

格式: grep [option] [pattern] [file1,file2...]

选项: -v:反转 -i:忽略大小写 -n:显示行号 -r:递归搜索 -E:扩展正则 -l:文件名

```bash
grep -r -l upload_max_filesize /etc/php

```



