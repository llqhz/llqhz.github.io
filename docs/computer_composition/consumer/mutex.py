#!/usr/bin/env python

import threading
import time

'''
线程锁互斥锁

# 创建锁
mutex = threading.Lock()

# 锁定
mutex.acquire()

# 释放
mutex.release()

'''


def consumer():
    global num
    for i in range(1, 100):
        # 阻塞等待
        mutex.acquire()

        # 执行逻辑
        tmp = num
        time.sleep(0.01)
        num = tmp - 1
        print("consumer {}: after:{}".format(i, num))

        # 释放锁
        mutex.release()

def producer():
    global num
    for i in range(1, 100):
        # 获取锁
        mutex.acquire()

        # 执行逻辑
        tmp = num
        time.sleep(0.01)
        num = tmp + 1
        print("producer {}: after:{}".format(i, num))

        # 释放锁
        mutex.release()


mutex = threading.Lock()

if __name__ == '__main__':
    # 定义初始值
    num = 0
    threads = []

    # 创建consumer线程
    t1 = threading.Thread(target=consumer, args=())
    threads.append(t1)

    # 创建producer线程
    t2 = threading.Thread(target=producer, args=())
    threads.append(t2)

    # 指定子线程就绪,让操作系统调度
    for sub_thread in threads:
        sub_thread.start()

    # 主线程退出    
    for sub_thread in threads:
        sub_thread.join()
    print("main thread finished, num: {}".format(num))

