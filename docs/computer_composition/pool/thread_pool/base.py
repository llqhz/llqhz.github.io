#!/usr/bin/env php
# coding:utf-8

# 互斥锁
# 条件变量 (会让出互斥锁)

import threading


# 互斥锁, 获取实例
# 创建锁
lock = threading.Lock()
# 加锁
lock.acquire()
# 解锁
lock.release()


# 条件变量
# 创建
condition = threading.Condition()
# 获取 (互斥锁,只允许一个线程acquire,阻塞等待)
condition.acquire()
# 释放 (主动释放acquire的互斥锁)
condition.release()
# 条件等待 (让出acquire的互斥锁,同时进入睡眠)
condition.wait()
# 条件通知 (通知其他wait睡眠的线程唤醒)
condition.notify()


# 队列Queue
# 使用线程安全的队列存放元素
# 1. 多个线程同时访问: 互斥锁保护线程安全
# 2. 线程池为空时:  使用条件变量等待队列中归还线程
































