<?php


namespace App\Http\Models;


class Algorithm
{
    public static function run()
    {
        // 二分查
    }

    /**
     * 二分查找, 递归版
     * 原理: 通过对比查找值与中点值的大小,来继续从左边或者右边递归进行查询
     * @param $arr
     * @return int
     */
    public static function binarySearch($arr, $value)
    {
        $low_index = 0;
        $high_index = count($arr) - 1;
        return self::binarySearchItem($arr, $value, $low_index, $high_index);
    }

    protected static function binarySearchItem($arr, $value, $low_index, $high_index)
    {
        if ($low_index > $high_index) {
            return -1;
        }

        $mid_index = intval(($high_index + $low_index) / 2);

        if ($value > $arr[$mid_index]) {
            return self::binarySearchItem($arr, $value, $mid_index + 1, $high_index);
        } elseif ($value < $arr[$mid_index]) {
            return self::binarySearchItem($arr, $value, $low_index, $mid_index - 1);
        } else {
            return $mid_index;
        }
    }

    /**
     * 二分查找, 循环版
     * 原理: 通过对比与中点值的大小,赋值新的low与high来递归查询
     * @param $arr
     * @param $value
     * @return int
     */
    public static function binarySearchCircle($arr, $value)
    {
        $low_index = 0;
        $high_index = count($arr) + 1;

        while ($low_index <= $high_index) {
            $mid_index = intval(($low_index + $high_index) / 2);

            if ($value == $arr[$mid_index]) {
                return $mid_index;
            } elseif ($value < $arr[$mid_index]) {
                $high_index = $mid_index - 1;
            } else {
                $low_index = $mid_index + 1;
            }
        }
        return $low_index <= $high_index ? $mid_index : -1;
    }

    /**
     * 冒泡排序
     * 原理: 通过不断交换相邻值,推动最大或最小值到最顶端,并循环
     * @param $arr array
     * @return array
     */
    public static function bubbleSort($arr)
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


    /**
     * 选择排序
     * 原理: 从当前部分找出最大或最小值,依次顺序放入顶端
     * @param $arr array
     * @return array
     */
    public static function selectSort($arr)
    {
        $len = count($arr);

        for ($i = 0; $i < $len - 1; $i++) {
            // 从当前部分找最小值索引
            $min_index = $i;
            for ($j = $i + 1; $j < $len; $j++) {
                if ($arr[$min_index] > $arr[$j]) {
                    $min_index = $j;
                }
            }
            // 将最小值放入顶端
            list($arr[$i], $arr[$min_index]) = [$arr[$min_index], $arr[$i]];
        }

        return $arr;
    }

    /**
     * 插入排序
     * 原理: 从剩下每个元素,依次插入前面合适位置
     * @param $arr
     * @return array
     */
    public static function insertSort($arr)
    {
        $len = count($arr);

        for ($i = 1; $i < $len; $i++) {
            // 将$i依次交换插入到前面合适位置
            for ($j = $i; $j > 0; $j--) {
                if ($arr[$i] < $arr[$j]) {
                    // 交换
                    list($arr[$i], $arr[$j]) = [$arr[$j], $arr[$i]];
                } else {
                    break;
                }
            }
        }

        return $arr;
    }

    /**
     * 归并排序
     * 原理: 先部分有序,然后再整体有序
     * @param $arr
     * @return array
     */
    public static function mergeSort($arr)
    {
        $len = count($arr);

        if ($len <= 1) {
            return $arr;
        }

        $mid = intval((0 + $len - 1) / 2);

        $left = array_slice($arr, 0, $mid);
        $right = array_slice($arr, $mid + 1);

        return self::mergeSortItem(self::mergeSort($left), self::mergeSort($right));
    }


    /**
     * 合并左右两部分数组
     * @param array $left
     * @param array $right
     * @return array
     */
    protected static function mergeSortItem($left = [], $right = [])
    {
        $temp = [];

        $len_left = count($left);
        $len_right = count($right);

        $i = $j = 0;

        while ($i < $len_left && $j < $len_right) {
            if ($left[$i] < $right[$j]) {
                $temp[] = $left[$i];
            } else {
                $temp[] = $right;
            }
        }

        while ($i < $len_left) {
            $temp[] = $left[$i];
        }
        while ($j < $len_right) {
            $temp[] = $right[$j];
        }
        return $temp;
    }

    /**
     * 快速排序
     * @param $arr
     * @return array
     */
    public static function quickSort($arr)
    {
        $len = count($arr);

        if ($len <= 1) {
            return $arr;
        }

        $partition = 0;

        $left = $right = [];
        for ($i = $partition + 1; $i < $len; $i++) {
            if ($arr[$i] < $arr[$partition]) {
                $left[] = $arr[$i];
            } else {
                $right[] = $arr[$i];
            }
        }

        return array_merge(self::quickSort($left), [$arr[$partition], self::quickSort($right)]);
    }

    /**
     * @param $arr
     * @return array
     */
    protected static function buildMaxHeap($arr)
    {
        $len = count($arr);

        // 堆化直接从倒数第二层开始向上堆化即可
        for ($i = $len - 1; $i < $len; $i--) {
            $parent = floor($len / 2);
            self::heapify($arr, $parent, $len);
        }

        return $arr;
    }

    /**
     * 从顶向下heapify
     * 原理: 找出最大值放顶上,并继续堆化子堆
     * @param $arr
     * @param $i
     */
    protected static function heapify(&$arr, $i, $len)
    {
        if ($i >= $len) {
            // 已经堆化到最后一个元素
            return;
        }

        // 堆的性质
        $child_1 = 2 * $i + 1;
        $child_2 = 2 * $i + 2;

        // 找出最大值放顶上,防止下标越界
        $max_index = $i;
        if ($child_1 < $len && $arr[$child_1] > $arr[$max_index]) {
            $max_index = $child_1;
        }
        if ($child_2 < $len && $arr[$child_2] > $arr[$max_index]) {
            $max_index = $child_2;
        }
        if ($max_index != $i) {
            list($arr[$max_index], $arr[$i]) = [$arr[$i], $arr[$max_index]];
            // 有较小值移入下方,需要对下方再进行堆化
            self::heapify($arr, $max_index, $len);
        }
    }

    /**
     * 堆排序
     * 原理: 构建大根堆,依次出堆排尾部,再堆化,循环进行
     * @param $arr
     * @return array
     */
    public static function heapSort($arr)
    {
        $arr = self::buildMaxHeap($arr);

        $len = count($arr);
        for ($i = $len - 1; $i >= 0; $i--) {
            // 依次取出最大值放最后面,前部分再堆化
            list($arr[$i], $arr[0]) = [$arr[0], $arr[$i]];
            self::heapify($arr, 0, $i);
        }

        return $arr;
    }


    /**
     * @param $arr
     * @return array
     * @link https://www.cnblogs.com/chengxiao/p/6104371.html
     */
    public static function shellSort($arr)
    {
        $len = count($arr);

        // 间隔,表示每隔gap个为一组,共分gap组
        for ($gap = floor($len / 2); $gap > 0; $gap = $gap / 2) {
            // 从左到右,依次排序每个元素
            for ($i = $gap; $i < $len; $i++) {
                // 向前移动该元素到有序位置
                for ($j = $i - $gap; $j > 0; $j -= $gap) {
                    if ($arr[$j + $gap] < $arr[$j]) {
                        list($arr[$j + $gap], $arr[$j]) = [$arr[$j], $arr[$j + $gap]];
                    } else {
                        break;
                    }
                }
            }
        }

        return $arr;
    }

    /**
     * 计数排序
     * 原理: 数组的值作为键,计数作为值,然后依次取出
     * @param $arr
     * @return array
     */
    public static function countingSort($arr)
    {
        $len = count($arr);
        $max = max($arr);

        // 初始化
        $temp = [];
        for ($i = 0; $i <= $max; $i++) {
            $temp[$i] = 0;
        }

        // 计数
        for ($i = 0; $i < $len; $i++) {
            $value = $arr[$i];
            $temp[$value]++;
        }

        // 输出
        for ($i = 0, $j = 0; $i <= $max; $i++) {
            while ($temp[$i] > 0) {
                $temp[$i]--;
                $arr[$j++] = $i;
            }
        }

        return $arr;
    }
}
