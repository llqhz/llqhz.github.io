# coding:utf-8
import time

from thread_pool import pool, task
from thread_pool.task import AsyncTask


class SampleTask(task.Task):
    def __init__(self, callable):
        super(SampleTask, self).__init__(callable)



def process():
    print('this is a process')
    time.sleep(1)
    return 'success'


def test():
    # 初始化线程池
    test_pool = pool.ThreadPool()

    # 就绪
    test_pool.start()

    # 生成并投递任务
    for i in range(10):
        sample_task = SampleTask(callable=process)
        test_pool.put(sample_task)

    for i in range(3):
        async_task = AsyncTask(func=process)
        result = async_task.get_result()
        print(result)


if __name__ == '__main__':
    test()
















































