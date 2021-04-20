# 标题

> 内容

### 冒泡排序

```php
/**
 * 冒泡排序
 * 原理: 通过不断交换相邻值,推动最大或最小值到最顶端,并循环
 * @param $arr array
 * @return array
 */
public function bubbleSort($arr)
{
    $len = count($arr);

    for ($i = 0; $i < $len; $i++) {
        for ($j = $i; $j + 1 < $len; $j++) {
            if ($arr[$j] > $arr[$j + 1]) {
                // 顺序递增, 不满足关系时交换
                list($arr[$j], $arr[$j + 1]) = [$arr[$j + 1], $arr[$j]];
            }
        }
    }

    return $arr;
}
```