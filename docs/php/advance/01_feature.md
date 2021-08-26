[TOC]

## 新特性

### 编译安装

下载解压源码

```shell
wget url/to/php.tar.gz

tar xfvz url/to/php.tar.gz

# ./configure --prefix=安装目录 --enable-fpm --enable-debug
./configure --prefix=/home/vagrant/code/learn/php_src/php-src/output --enable-fpm --enable-debug
make 
make install
```

### 基准测试

结论: PHP7比PHP5快2倍多

### PHP7新特性

#### 语法新特性

##### 太空船操作符: <=>

```php
echo 1 <=> 2;  // -1 

// 等价于
function judge($a, $b) {
    return $a == b ? 0 : ( $a > b ? 1 : -1 );
}
```

##### 类型声明

```php
declare(strict_types=1);

function sum(int $a, int $b): int {
    return $a + $b;
}
```

##### null合并运算符

```php
$page = isset($_GET['p']) ? $_GET['p'] : 1;

$page = $_GET['p'] ?? 1;
```

常量数组

```php
define('ANIMALS', ['dog', 'cat', 'bird']);
```

##### 命名空间批量导入

```php
use Space\{ClassA, ClassB, ClassC as C}
```

##### Throwable接口

```php
try {
    undefinedFun();
} cache (Throwable $e) {
    var_dump($e->getMessage());
}
```

> Error 在php7中也可以用set_exception_handler来捕获

##### Closure::call

> Closure->call($scope_object, string $scope_static): mixed

```php
class Test
{
    private $num = 1;
}

# 闭包的call
$outer_fun = function () {
    return $this->num++;
}
echo $outer_fun->call(new Test());
```

##### intdiv函数

```php
echo intdiv(10, 3);
# 等价于
echo intval(10 / 3);
```

##### list的方括号写法

```php
list($a, $b, $c) = [1, 2, 3];
# 新方法
[$a, $b, $c] = [1, 2, 3];
```

#### 底层新特性

##### 抽象语法树

```php
($a)['b'] = 1;

var_dump($a);  // [ "b" => 1 ]
```

