#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <pthread.h>
#include <vector>


/*
线程锁读写锁
说明: 读写锁 (对读不加锁,对写加互斥锁)

# 创建锁
pthread_rwlock_t rwlock = PTHREAD_RWLOCK_INITIALIZER;

# 锁定
pthread_rwlock_rdlock(&rwlock);  // 读
pthread_rwlock_wrlock(&rwlock);  // 写

# 释放
pthread_rwlock_unlock(&rwlock);

*/


int num = 0;

pthread_rwlock_t rwlock = PTHREAD_RWLOCK_INITIALIZER;

void *reader(void*){
    int times = 10000000;
    while(times --){
        pthread_rwlock_rdlock(&rwlock);
	    if (times % 1000 == 0){
            printf("print num in reader: num = %d\n", num);
            usleep(10);
        }
        pthread_rwlock_unlock(&rwlock);
    }
}

void *writer(void*){
    int times = 10000000;
    while(times --){
        pthread_rwlock_wrlock(&rwlock);
	    num += 1;
        pthread_rwlock_unlock(&rwlock);
    }
}


int main(){
    printf("Start in main function.\n");
    pthread_t thread1, thread2, thread3;
    pthread_create(&thread1, NULL, &reader, NULL);
    pthread_create(&thread2, NULL, &reader, NULL);
    pthread_create(&thread3, NULL, &writer, NULL);
    pthread_join(thread1, NULL);
    pthread_join(thread2, NULL);
    pthread_join(thread3, NULL);
    printf("Print in main function: num = %d\n", num);
    return 0;
}

