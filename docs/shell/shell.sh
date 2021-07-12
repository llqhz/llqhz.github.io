#!/usr/bin/env bash

#############
# shell 变量
#############

# 显示赋值
name='test name'
echo ${name}

# 语句赋值
for file in /etc/*; do
    echo ${file}
done

# 使用变量
name='xiao_ming'
echo ${name}
# 变量需要用{}限定变量字符界

# 只读变量
age=32
readonly age
# age=33  # readonly变量不能被重新赋值
echo ${age}


# 删除变量
name='xiao_hong'
unset name
echo "after unset; name is: [${name}]"
# unset 变量后,相关于变量没有被赋值过


# shell 变量范围
# 1 局部变量
# 2 环境变量
# 3 shell变量 (系统定义的变量,预定义变量)


#############
# shell 变量类型
#############

# 字符串
first_name='xiao'
last_name='ming'
full_name=xiao-hong
name1='${first_name}\n${last_name}'
name2="${first_name}\n${last_name}"
echo ${name1}
echo ${name2}
echo ${full_name}
# 字符串可以不使用引号,单引号里的任何字符都会原样输出, 而双引号会解析变量

name='xiao_ming'
str="my name \t is \"${name}\"! "
echo -e ${str}

# -e 转义及颜色
# echo -e "\e[字背景颜色;字体颜色m字符串\e[0m"
echo -e "\e[42;31mThis is red text\e[0m"


# 拼接字符串
first_name='xiao_ming'
last_name='xiao_hong'
words1="hello, "${first_name}" !"
words2="hello, ${first_name} !" # 双引号

words3='hello, '${last_name}' !'
words4='hello, ${last_name} !'
echo $words1, $words2, $words3, $words4
# 备注: 单引号之间可以拼接变量,双引号需要将变量包含在里面


# 获取字符串长度
name="hello world"
echo ${#name}

# 字符串切片
echo ${name:1}
echo ${name:1:5}
# echo ${name:1:-1}  # 可能不被支持
# 备注: 索引从0开始

# 字符查找
text='this is a hello world'
echo `expr index "${text}" eo`

# 字符截取
text='this is a hello world'
echo  substr: `expr substr "${text}" 2 3`



# shell数组 ()表示,空格分开,仅支持一位数组

# 数组定义
names=('xiao_ming' 'xiao_hong' 'xiao_li')
ages=(0)
ages[2]=2

# 数组输出
echo ${names[2]}, ${ages[1]}, ${ages[2]}
echo "${ages[@]}"
echo "${ages[*]}"
# 备注: $*与$@; 只有在双引号中体现出来:  "*"=> "1 2 3", "@"=>"1" "2" "3"


# 获取数组的长度
len1=${#names[@]}
len2=${#names[*]}
echo '获取数组的长度', ${len1}, ${len2}

# 数组单个元素的长度
len_elem=${#names[1]}
echo ${len_elem}


# Shell 注释
# 单行注释

# 多行注释 ":<<"+标识符
:<<EOF
这里是多行注释01
这里是多行注释02
EOF

:<<!
这里是多行注释01
这里是多行注释02
!

# shell脚本参数
echo '传递脚本的参数:'
echo '传递脚本的参数,$0:' [${0}]
echo '传递脚本的参数,$1' [${1}]
echo '传递脚本的参数,$2:' [${2}]

echo ${#}  # 参数个数
echo '参数字符串', "${*}"  # 参数字符串
echo '具体每个参数', "${@}"  # 具体每个参数

echo '当前进程号', ${$} # 当前进程号
echo '后台运行的最后一个进程的ID号', ${!} # 最后一个进程号

echo '显示Shell使用的当前选项:', $-
echo '显示最后命令的退出状态:', $?


# 基本运算符
# 算数运算,关系运算,bool运算,字符串运算,文件测试运算

# 算数运算
# 备注: shell本身不支持数学运算:a=${a}+1 => "1+1" (加号作为字符串而不解析为加法运算)
# expr 2 + 2 的 +两边要有空格
a=20
b=6
a1=`expr ${a} + ${b}`
a2=`expr ${a} - ${b}`
a3=`expr ${a} \* ${b}`
a4=`expr ${a} / ${b}`
a5=`expr ${a} % ${b}`

echo ${a1}, ${a2}, ${a3}, ${a4}, ${a5}


# 关系运算(数字) 字母比较+双等判断
if [ ${a} -eq ${b} ]; then
    echo ${a} 'eq' ${b}
fi
if [ ${a} -ne ${b} ]; then
    echo ${a} 'ne' ${b}
fi
if [ ${a} -gt ${b} ]; then
    echo ${a} 'gt' ${b}
fi
if [ ${a} -lt ${b} ]; then
    echo ${a} 'lt' ${b}
fi
if [ ${a} -ge ${b} ]; then
    echo ${a} 'ge' ${b}
fi
if [ ${a} -le ${b} ]; then
    echo ${a} 'le' ${b}
fi
if [ ${a} == ${b} ]; then
    echo ${a} '==' ${b}
fi
if [ ${a} != ${b} ]; then
    echo ${a} '!=' ${b}
fi


# 字符串运算符 字母检测+单等判断
s1='abc'
s2='def'
if [ "${s1}" = "${s2}" ]; then
    echo "${s1} = ${s2}"
fi
if [ "${s1}" != "${s2}" ]; then
    echo "${s1} != ${s2}"
fi
if [ -n "${s1}" ]; then
    echo "-n ${s1} 长度不为0"
fi
if [ -z "${s1}" ]; then
    echo "-z ${s1} 长度为0"
fi
if [ ${s1} ]; then
echo "${s1} 字符串非空"
fi


# 逻辑运算 []为检测 [[]] 为逻辑符号
a=10
b=20
if [ ${a} -lt 30 ] && [ ${b} -lt 30 ]; then
    echo 'and'
fi
if [ ${a} -lt 30 ] || [ ${b} -lt 30 ]; then
    echo 'or'
fi
if [[ ${a} -lt 30 && ${b} -lt 30 ]]; then
    echo 'and'
fi
if [[ ${a} -lt 30 || ${b} -lt 30 ]]; then
    echo 'or'
fi
if [ ! ${a} ] && ! [ ${a} -lt ${b} ]; then
    echo 'not a'
fi

# 文件测试运算符
file1='../test.md'
if [ -d ${file1} ]; then
    echo '是目录'
fi
if [ -f ${file1} ]; then
    echo '是文件'
fi
if [ -e ${file1} ]; then
    echo '文件或目录存在'
fi
if [ -r ${file1} ] && [ -w ${file1} ] || [ -x ${file1} ] ; then
    echo '文件可读,可写 或者 可执行'
fi


# echo 命令
echo "this is a word."
echo this is a word.
# 转义
echo "this is an \"apple\""
# 变量
name='xiao ming'
echo "my name is ${name}"
# 解析
echo -e "hello \nworld"

# echo "It is a test" > myfile
echo `date`
echo `date +%Y%m%d`

# printf
printf "hello world"
printf "[%s] [%-8d] [%3.6f]\n" "great" 65 3.7

# 判断
num=10
if [ ${num} -eq 10 ]; then
    echo 'num -ge 10'
elif [ ${num} -gt 10 ]; then
    echo 'num gt 10'
else
    echo 'num -lt 10'
fi

case ${num} in
    1)
        echo 1
    ;;
    2|3)
        echo 2 or 3
    ;;
    1*)
        echo '1*'
    ;;
    *)
        echo default
    ;;
esac

# 循环
for (( i = 0; i < 3; i++ )); do
    echo $i
done

# for i in $(seq 1 $num)
for i in {1..3}; do
    if [ ${i} -eq 2 ]; then
        break
    else
        echo $i
        continue
    fi
done

while (( i < 5 )); do
    echo $i
    let i++
done
# while read word; do
#     echo ${word}
# done

until [ ${i} -gt 8 ]; do
    echo ${i}
    (( i++ ))
done


# shell 算数计算
let i++
i=`expr ${i} + 1`
(( i++ ))
i=$(( i++ ))


# shell函数
function print_hello() {
    echo 'hello world in function, param:'${0}
}
print_hello

function xiao_sum() {
    num1=${1}
    num2=${2}
    return $(( num1 + num2 ))
}
xiao_sum 1 3
echo 'sum 1 3 = '${?}


# 重定向
ps -ef > 001.log 2>&1
# 0:STDIN 1:STDOUT 2:STDERR 2>&1 ERR合并到OUT中

ps -ef > /dev/null 2>&1

# shell heredoc
wc -l << EOF
one
two
EOF

# 文件包含
. ./test/01.sh
source ./test/01.sh

# 配置文件
echo $PATh

# 正则表达式
# 字符串匹配查找分割替换的模式规则
# 正则: * . ? [0-9] ^ () $
# 通配符: * ? []
# 正则:   文件内容  包含匹配  字符串别通正则
# 通配符: 文件名    完全匹配  文件识别通配符

# 通配符 * 匹配 0或者N个任意[字符]
# 正则 * 匹配 前一个字符任意多[次]


# grep
# grep -v pattern
# grep [pattern] files
# grep -E "[pattern]" files

# cut
cut -f 1,2 -d ":" /ect/passwd
# 提取 1,2列 用:分割


# awk 执行语句单引号
# awk -F ':' '[条件]{语句} [条件]{语句} [条件]{语句} ...'
# 条件 [BEGIN],[END],[x>=10]
# 语句 {print printf}
# 内置变量 $n, NR(纪录号),FNR(文件行号),OFS(输出分隔符)

cat /etc/passwd | awk -F ':' '
BEGIN {
    FS=":"
    sum=0
    num=0
    printf "行号\t用户名\t密码\tuid\tgid\t显示名\t家目录\t登录\tsum\n"
}
$1 !~ /^_s/ {
    num=num+1;
    if (num % 2 == 0)
        num=num+3;
    else
        while (num % 5 < 3)
            num=num+1;
        sum=sum+$3;
    printf "%d\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\n", NR, $1, $2, $3, $4, $5, $6, $7, sum
}
END {
    print "----------"
}
'


cat > student.txt <<EOF
姓名    年龄    性别    分数
小明    20    男    100
小虹    28    女    70
小黄    24    女    85
小王    22    男    5
EOF

# sed 替换
# sed [选项] '[动作]' 文件名
# 选项: -n(输出) -i(修改原文件) -e(允许多条sed动作)
# 动作: a(追加) c(行替换) s(字符串替换) i(插入) p(打印)

cat student.txt
sed -n '2,4p' student.txt
sed '2,3d' student.txt # 删除特定行
sed '2,3i iiiiiii' student.txt # 之前行插入
sed '2,3a aaaaaaa' student.txt # 之后行追加
sed '2,3c XXXXXXX' student.txt # 替换整行
sed '2,3s/100/优秀/g' student.txt # 替换字符串

sed -e '2,3s/100/优秀/g;2,3s/70/不及格/g;' student.txt # 替换字符串

# sort
# -n(数值格式) -r(倒序) -t(分隔符) -k(指定列)
sort -n -r -t " " -k "4,4" student.txt

# wc
# -l(行数) -w(单词数) -m(字符数)
ps -ef | wc -l
