#!/usr/bin/env bash

function m_add() {
    local result=''
    for i in "${@}"; do
        if [ -z "${result}" ]; then
            result=${i}
            continue
        fi
        (( result += i ))
    done
    echo $result
}

function m_reduce() {
    local result
    for i in "${@}"; do
        if [ -z "${result}" ]; then
            result=${i}
            continue
        fi
        (( result -= i ))
    done
    echo $result
}

function m_multiply() {
    local result
    for i in "${@}"; do
        if [ -z "${result}" ]; then
            result="${i}"
            continue
        fi
        (( result *= i ))
    done
    echo $result
}

function m_divide() {
    local result
    for i in "${@}"; do
        if [ -z "${result}" ]; then
            result=${i}
            continue
        fi
        (( result /= i ))
    done
    echo $result
}

function test_m_calculate() {
    local num1=$(m_add 1 2 3 4 5)
    local num2=$(m_reduce 100 1 2 3 4 5)
    local num3=$(m_multiply 1 2 3 4 5)
    local num4=$(m_divide 100 1 2 3 4 5)

    echo "${num1} ${num2} ${num3} ${num4}"
}



# 算数计算
# test_m_calculate

# 字符串
function m_substr() {
    local str offset length str_length
    str="${1}"
    offset="${2}"
    length="${3}"
    str_length=${#str}

    if [ "${length}" -gt "${str_length}" ]; then
        length=${str_length}
    fi
    echo ${str:${offset}:${length}}
}

function m_str_pos() {
    local str needle str_length sub_str sub_str_start pos
    str="${1}"
    needle="${2}"
    str_length=${#str}
    readonly needle_length=${#needle}
    pos=-1
    
    for (( i = 0; i + needle_length <= str_length; ++i )); do
        sub_str_start=${i}
        sub_str=${str:${sub_str_start}:${needle_length}}

        if [ "${sub_str}" = "${needle}" ]; then
            pos=${i}
            break
        fi
    done
    echo $pos
}

function test_m_str() {
    local str1 str2 str3
    str1=$(m_substr "hello world" 6 3)
    str2=$(m_str_pos "hello world" "wor")

    printf "substr:  ${str1}\n"
    printf "str_pos:  ${str2}\n"
}

# 字符串测试
# test_m_str


function array_push() {
    local m_arr=() len=${#} v j=0
    local last=$(( len - 1 ))
    for i in "${@}"; do
        (( j++ ))
        if [ "${j}" -eq ${last} ]; then
            # 最后一个
            break
        fi
        m_arr=(${m_arr[@]} ${i})
    done
    echo "${m_arr[@]}"
}

