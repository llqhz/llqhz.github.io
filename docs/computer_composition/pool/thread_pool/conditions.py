# coding:utf-8

import threading
import time


if __name__ == '__main__':

    condition = threading.Condition()

    def consumer():
        while True:
            name = threading.current_thread().getName()
            print(f'{name} acquire cond ...')
            condition.acquire()
            print(f'{name} acquire cond suc')
            time.sleep(1)

            print(f'{name} notify before ...')
            condition.notify()  # 通知其他线程
            print(f'{name} notify suc.')
            time.sleep(1)

            print(f'{name} wait before ...')
            condition.wait()  # 释放锁
            print(f'{name} wait end.')
            time.sleep(1)

    thread1 = threading.Thread(target=consumer, args=(), name='thread1')
    thread2 = threading.Thread(target=consumer, args=(), name='thread2')
    thread3 = threading.Thread(target=consumer, args=(), name='thread3')

    thread1.start()
    thread2.start()
    thread3.start()

    thread1.join()
    thread2.join()
    thread3.join()

    """
    输出:
    thread1 acquire cond ...
    thread1 acquire cond suc
    thread2 acquire cond ...
    thread3 acquire cond ...
    thread1 notify before ...
    thread1 notify suc.
    thread1 wait before ...
    thread2 acquire cond suc
    thread2 notify before ...
    thread2 notify suc.
    thread2 wait before ...
    thread3 acquire cond suc
    thread3 notify before ...
    thread3 notify suc.
    thread3 wait before ...
    thread1 wait end.
    thread1 acquire cond ...
    thread1 acquire cond suc
    thread1 notify before ...
    thread1 notify suc.
    thread1 wait before ...
    thread2 wait end.
    thread2 acquire cond ...
    thread2 acquire cond suc
    thread2 notify before ...
    thread2 notify suc.
    thread2 wait before ...
    thread3 wait end.
    thread3 acquire cond ...
    thread3 acquire cond suc
    thread3 notify before ...
    thread3 notify suc.
    thread3 wait before ...
    thread1 wait end.
    """