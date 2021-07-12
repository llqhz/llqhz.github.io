# Shell

## shell 变量

### 变量的基本使用
#### 变量赋值

##### 显式赋值

```bash
name='test name'
echo ${name}
```

##### 隐式赋值
```bash
for file in ls /etc/*; do
    echo ${file}
done
```

#### 使用变量
```bash
name='test name'
echo ${name}
echo "${name}"
```
> 备注: 变量需要用{}限定变量字符界,在判断条件中最好给变量加双引号


#### 只读变量
```bash
age=32
readonly age
age=33  # 报错,readonly变量不能被重新赋值
echo ${age}
```
> 备注: readonly变量不能被重新赋值

#### 删除变量
```bash
name='xiao hong'
unset ${name}
echo "after unset; name is: [${name}]"
```
> 备注: unset 变量后,相关于变量没有被赋值过


[filename](./shell.sh ':include :type=code shell')



