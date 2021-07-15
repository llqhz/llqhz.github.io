#!/usr/bin/env bash

# 搜索指定网址并点击

# 关键词
word='筱怪的博客'

# 网址
site='www.llqhz.cn'

# 百度搜索网址
baidu_url='https://www.baidu.com/s?wd='




default_headers=(
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9'
    'Accept-Encoding: deflate, br'
    'Accept-Language: zh-CN,zh;q=0.9'
    'Cache-Control: max-age=0'
    'Connection: keep-alive'
    'Host: www.baidu.com'
    'sec-ch-ua: " Not;A Brand";v="99", "Google Chrome";v="91", "Chromium";v="91"'
    'sec-ch-ua-mobile: ?0'
    'Sec-Fetch-Dest: document'
    'Sec-Fetch-Mode: navigate'
    'Sec-Fetch-Site: none'
    'Sec-Fetch-User: ?1'
    'Upgrade-Insecure-Requests: 1'
    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36'
)



function get_search_url() {
    echo "${1}${2}"
}

function get_headers() {
    local headers=()

    for i in "$@"; do
        headers[${#headers[@]}]="-H'${i}'"
    done
    echo ${headers[@]}
}

function http_get() {
    # 获取headers
    local headers=($(get_headers "${default_headers[@]}"))

    # url
    local url="$1"

    # 组装执行命令
    cmd="curl -L ${headers[@]} ${url}"

    # 开始执行
    local result=$(eval "${cmd}")

    # 返回
    echo "$result"
}

function parse_http_result_url() {
    local result="$*"

    echo ${result} > baidu.html

    local url=$(echo ${result} | grep -Eo "(<[^<>]+?>)${site}" | grep -Eo 'http[^"]+')
    echo $url
}

function run() {
    # 获取url
    local url=$(get_search_url ${baidu_url} ${word})

    # 通过http_get获取返回
    local result=$(http_get ${url})

    # 解析返回结果
    local site_baidu_url=$(parse_http_result_url ${result})

    echo ${site_baidu_url}

    # 通过http_get访问解析后的url
    result=$(http_get ${site_baidu_url})

    echo "${result[*]}"
}

# 主方法开始执行
run
