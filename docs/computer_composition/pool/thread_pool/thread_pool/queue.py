# coding:utf-8

import threading
import time


class ThreadSafeQueueException(object):
    pass


class ThreadSafeQueue(object):

    def __init__(self, max_size=0):
        self.queue = []
        self.max_size = max_size
        self.lock = threading.Lock()
        self.condition = threading.Condition()

    # 当前队列元素的数量(线程安全)
    def size(self):
        # 加锁
        self.lock.acquire()

        size = len(self.queue)

        # 解锁
        self.lock.release()
        return size

    # 放入元素
    def put(self, item):
        # 加锁
        self.lock.acquire()

        if self.max_size != 0 and len(self.queue) > self.max_size:
            # 解锁
            self.lock.release()
            return ThreadSafeQueueException()

        self.queue.append(item)

        # 解锁
        self.lock.release()

        # 条件变量通知
        self.condition.acquire()
        self.condition.notify()
        self.condition.release()

        return True

    # 批量put
    def batch_put(self, item_list):
        if not isinstance(item_list, list):
            item_list = list(item_list)
        for item in item_list:
            self.put(item)
        return True

    # 条件变量加锁等待
    def pop(self, block=False, timeout=0):
        if self.size() == 0:
            # 需要阻塞
            if block:
                self.condition.acquire()
                self.condition.wait(timeout=timeout)
                self.condition.release()
            else:
                return None

        if self.size() == 0:
            return None

        self.lock.acquire()
        item = self.queue.pop()
        self.lock.release()
        return item

    def get(self, i):
        if self.size() == 0:
            return None
        self.lock.acquire()
        item =  self.queue[i]
        self.lock.release()
        return item


if __name__ == '__main__':
    queue = ThreadSafeQueue(max_size=100)

    def producer():
        while True:
            queue.put(1)
            print('put item from queue: {}'.format(1))
            time.sleep(1)

    def consumer():
        while True:
            item = queue.pop()
            print('get item from queue: {}'.format(item))
            time.sleep(1)
    # 创建线程
    thread1 = threading.Thread(target=producer, args=())
    thread2 = threading.Thread(target=consumer, args=())

    # 唤醒就绪
    thread1.start()
    thread2.start()

    # 主进程退出
    thread1.join()
    thread2.join()












