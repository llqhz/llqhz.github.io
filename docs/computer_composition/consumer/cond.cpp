#include <iostream>
#include <stdio.h>
#include <stdlib.h>
#include <vector>
#include <queue>
#include <unistd.h>
#include <pthread.h>

/*
线程同步: 条件变量
说明: 用while循环判断收到通知后是否满足条件
注意: pthread_cond_wait会让出当前线程的互斥锁

# 创建锁
pthread_cond_t cond = PTHREAD_COND_INITIALIZER;
pthread_mutex_t mutex = PTHREAD_MUTEX_INITIALIZER;

# 加锁并进行条件判断
pthread_mutex_lock(&mutex);
while(cond==false) pthread_cond_wait(&cond, &mutex);  // 阻塞等待通知

# 通知并解锁
pthread_cond_signal(&cond);
pthread_mutex_unlock(&mutex);
*/ 

int MAX_BUF = 10;
int num = 0;

pthread_cond_t cond = PTHREAD_COND_INITIALIZER;
pthread_mutex_t mutex = PTHREAD_MUTEX_INITIALIZER;

void* producer(void*){
    while(true){
        // 获取锁和条件检测
        pthread_mutex_lock(&mutex);
        printf("生产者加锁++++++++++++++++\n");
        while (num >= MAX_BUF){
            // 条件不满足,阻塞等待, 同时释放互斥锁
            printf("缓冲区满了, 等待消费者消费...\n");
            pthread_cond_wait(&cond, &mutex);
        }

        num += 1;
        printf("生产一个产品，当前产品数量为：%d\n", num);
        usleep(10);
        printf("通知消费者...\n");
        
        // 通知条件变量更新
        pthread_cond_signal(&cond);
        printf("生产者解锁-----------------\n");
        pthread_mutex_unlock(&mutex);
        
        // 解锁之后,要让出一段时间的执行权,供其他线程获取锁
        usleep(10);
    }
}

void* consumer(void*){
    while(true){
        // 获取锁和条件检测
        pthread_mutex_lock(&mutex);
        printf("消费者加锁++++++++++++++++\n");
        while (num <= 0){
            // 条件不满足, 等待, 同时释放互斥锁
            printf("缓冲区空了, 等待生产者生产...\n");
            pthread_cond_wait(&cond, &mutex);
        }
        
        num -= 1;
        printf("消费一个产品，当前产品数量为：%d\n", num);
        sleep(1);
        printf("通知生产者...\n");

        // 通知条件变量更新并解锁
        pthread_cond_signal(&cond);
        printf("消费者解锁-----------------\n");
        pthread_mutex_unlock(&mutex);
        sleep(1);
    }
}

int main(){
    pthread_t thread1, thread2;
    pthread_create(&thread1, NULL, &consumer, NULL);
    pthread_create(&thread2, NULL, &producer, NULL);
    pthread_join(thread1, NULL);
    pthread_join(thread2, NULL);
    return 0;
}
