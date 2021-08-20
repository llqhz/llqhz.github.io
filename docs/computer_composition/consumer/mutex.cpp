#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <pthread.h>
#include <vector>

/*
线程锁互斥锁
说明: 互斥锁是排他锁,只允许某个线程独占,其他进程进入睡眠阻塞状态,等待通知唤醒就绪

# 创建锁
pthread_mutex_t mutex = PTHREAD_MUTEX_INITIALIZER;

# 锁定
pthread_mutex_lock(&mutex);

# 释放
pthread_mutex_unlock(&mutex);
*/


pthread_mutex_t mutex = PTHREAD_MUTEX_INITIALIZER;

// 临界资源
int num = 0;

// 生产者
void *producer(void*){
    int times = 100000000;
    while(times --){
        pthread_mutex_lock(&mutex);
        num += 1;
        pthread_mutex_unlock(&mutex);
    }
}

// 消费者
void *comsumer(void*){
    int times = 100000000;
    while(times --){
        pthread_mutex_lock(&mutex);
        num -= 1;
        pthread_mutex_unlock(&mutex);
    }
}


int main(){
    printf("Start in main function.");
    pthread_t thread1, thread2;
    pthread_create(&thread1, NULL, &producer, NULL);
    pthread_create(&thread2, NULL, &comsumer, NULL);
    pthread_join(thread1, NULL);
    pthread_join(thread2, NULL);
    printf("Print in main function: num = %d\n", num);
    return 0;
}

