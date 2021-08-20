# coding:utf-8
import multiprocessing
import threading

from thread_pool.queue import ThreadSafeQueue
from thread_pool.task import Task, AsyncTask


class ProcessProcess(threading.Thread):

    def __init__(self, task_queue, *args, **kwargs):
        super().__init__(*args, **kwargs)

        self.dismiss_flag = threading.Event()

        self.task_queue = task_queue
        self.args = args
        self.kwargs = kwargs

    def run(self):
        while True:
            if self.dismiss_flag.is_set():
                break

            task = self.task_queue.pop()
            if not isinstance(task, Task):
                continue
            result = task.callable(*task.args, **task.kwargs)

            if isinstance(task, AsyncTask):
                task.set_result(result)


    def dismiss(self):
        self.dismiss_flag.set()

    def stop(self):
        self.dismiss()



class ThreadPool(object):

    def __init__(self, size=0):
        if not size:
            size = multiprocessing.cpu_count() * 2
        # 线程池
        self.pool = ThreadSafeQueue(size)
        # 任务队列
        self.task_queue = ThreadSafeQueue()

        for i in range(size):
            self.pool.put(ProcessProcess(self.task_queue))

    def start(self):
        for i in range(self.pool.size()):
            thread = self.pool.get(i)
            thread.start()

    # 停止
    def join(self):
        for i in range(self.pool.size()):
            thread = self.pool.get(i)
            thread.stop()
        while self.size():
            thread = self.pool.pop()
            thread.join()

    def put(self, task):
        if not isinstance(task, Task):
            return
        self.task_queue.put(task)

    def batch_put(self, item_list):
        for item in item_list:
            self.put(item)

    def size(self):
        return self.pool.size()












