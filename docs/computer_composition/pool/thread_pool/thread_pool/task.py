# coding:utf-8
import threading
import uuid

class Task(object):

    def __init__(self, func, *args, **kwargs):
        self.id = uuid.uuid4()

        self.callable = func
        self.args = args
        self.kwargs = kwargs

    def __str__(self):
        return 'task id: ' + str(self.id)


class AsyncTask(Task):

    def __init__(self, func, *args, **kwargs):
        super(AsyncTask, self).__init__(func, *args, **kwargs)
        self.result = None
        self.condition = threading.Condition()

    def set_result(self, result):
        self.condition.acquire()
        self.result = result
        self.condition.notify()
        self.condition.release()

    def get_result(self):
        self.condition.acquire()
        result = self.result
        if result == None:
            self.condition.wait()
            result = self.result
        self.condition.release()
        return result


if __name__ == '__main__':
    def my_function(name):
        print('this is a task, name:{}'.format(name))

    task = Task(func=my_function, args=("xiaoming"))

    print(task)



























































