#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <pthread.h>
#include <vector>


/*
线程锁自旋锁
说明: 自旋锁一直轮询检测,不会让出cpu执行权

# 创建锁
pthread_spinlock_t spin_lock;

# 锁定
pthread_spin_lock(&spin_lock);

# 释放
pthread_spin_unlock(&spin_lock);

*/


pthread_spinlock_t spin_lock;

int num = 0;

void *producer(void*){
    int times = 10000000;
    while(times --){
        // 自旋锁,循环判断,等待
	    pthread_spin_lock(&spin_lock);
        num += 1;
	    pthread_spin_unlock(&spin_lock);
    }
}

void *comsumer(void*){
    int times = 10000000;
    while(times --){
        // 自旋锁,循环判断等待
	    pthread_spin_lock(&spin_lock);
        num -= 1;
	    pthread_spin_unlock(&spin_lock);
    }
}


int main(){
    printf("Start in main function.\n");
    pthread_spin_init(&spin_lock, 0);
    pthread_t thread1, thread2;
    pthread_create(&thread1, NULL, &producer, NULL);
    pthread_create(&thread2, NULL, &comsumer, NULL);
    pthread_join(thread1, NULL);
    pthread_join(thread2, NULL);
    printf("Print in main function: num = %d\n", num);
    return 0;
}

