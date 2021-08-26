// 头文件
#include <stdio.h>
#include <string.h>
#include <errno.h>
#include <stdarg.h>  // 可变参数
#include <stdlib.h>  // 内存分配

/**
 * C语言示例
 */
// 预处理指令
#define COMMON_AREA_HEIGHT 10;


// 全局变量
int global_a = 0;

// 引用外部文件变量
extern int errno;


// 函数声明+实现
int max (int, int);  // 声明
int max (int a, int b) {  // 实现
    return a > b ? a : b;
}
void swap (int *a, int *b) {  // 传地址
    int tmp;
    tmp = *a;
    *a = *b;
    *b = tmp;
}


// 数组函数
int * sub_items(const int items[], const int *items2, int len) {
    int temps[len - 1];
    for (int i = 0; i < len; ++i) {
        if (i % 2) {
            temps[i] = items[i];
        } else{
            temps[i] = *(items2 + i);
        }
    }
    return temps;
}

// 结构体函数
// 扩展类型-结构体
struct UserInfo {
    int id;
    char name[20];
};
struct UserInfo * increase_user_id(struct UserInfo *user) {
    user->id++;
    (*user).id++;
    return user;
}

// 共用体函数
union UserKey {
    int id;
    char key;
};
union UserKey * decrease_user_id(union UserKey *user) {
    (*user).id--;
    user->id--;
    return user;
}


// 可变参数函数
int sum_args(int num, ...) {
    int num_i, sum = 0;

    /* va_list指针 */
    va_list vl;

    /* 为 num 个参数初始化 valist */
    va_start(vl, num);

    /* 访问所有参数 */
    for (int i = 0; i < num; i++) {
        num_i = va_arg(vl, int);  // 取出参数
        sum += num_i;
    }

    /* 清理为vl内存 */
    va_end(vl);

    return sum;
}

// 函数式
int call_max(int a, int b, int (*p_fun)(int , int)) {
    return p_fun(a, b);
}


int main(int argc, char *argv[]) {

    // 单行注释

    /**
     * 多行注释
     * 多行注释
     */

    // 数据类型
    // 数字
    int a = -2;
    float b = 3.2;
    double c = 2.2;

    // 字符
    char d = 'c';
    printf("数字: [%d, %f, %f], 字符:[%c]\n", a, b, c, d);

    // 变量(声明+赋值)+常量
    int fa;
    fa = 10 + global_a;  // 全局+局部
    const char CHAR_NAME = 'E';  // 常量(单引号) 局部常量
    fa = fa + COMMON_AREA_HEIGHT + 10;  // 全局常量


    // 变量作用域
    auto int mouth;  // 局部变量
    register int year;  // 寄存器局部变量,没有地址,不能进行&取地址运算
    static int day = 356;  // 静态变量,作用域为当前文件
    // extern int count;  // 从其他文件读取变量值

    // 运算符
    unsigned int ma = 10, mb = 20;
    ma = ma + mb - mb * mb / mb % mb;  // 算术
    if (ma == mb && (mb > ma) || ma <= mb) {}  // 逻辑+关系
    ma = ~ma & mb | mb ^ ma;  //  位运算

    // 特殊运算符
    unsigned int *pa = &mb;  // sizeof, &, *, ?:
    ma = sizeof(*pa) == ma ? 1 : 0;

    // 流程控制,条件判断: if-else, switch-case,
    if (ma > 0) {
        printf("1");
    } else if (ma == 0) {
        printf("2");
    } else {
        printf("3");
    }
    switch (ma) {
        case 10:
        case 20:
            printf("10/20");
            break;
        default:
            printf("case: default\n");
    }

    // 流程控制-循环: while, do-while, for
    int ca = 3;
    while (ca-- > 0) {
        printf("%d\n", ca);
    }
    // --------
    do {
        printf("%d\n", ca);
    } while (ca++ >= 4);
    // --------
    for (int i = 0; i < 3; ++i) {
        printf("%d\n", i);
    }

    // 函数, 定义+传值+传地址
    int ta = 0, tb = 20, tc;
    tc = max(ta, tb);  // 传值
    swap(&ta, &tb);  // 传地址

    // 扩展类型-数组
    int nums1[] = {1, 2, 3, 5, 6}, nums2[] = {11, 12, 13, 15, 16};
    int *nums3 = NULL;  // 指针默认值是NULL常量
    nums3 = sub_items(nums1, nums2, 4);  // 数组参数的传递与返回
    for (int j = 0; j < 4; ++j) {
        printf("j:%d => %d,%d\n", j, nums3[j], *(nums3 + j));  // 数组指针的取值,两种
    }

    // 字符串
    char words[6] = {'H', 'e', 'l', 'l', 'o', '\0'}, greet_cat[20];
    char greet[] = "Hello World";
    strcpy(greet_cat, greet); strcat(greet_cat, words);  // copy+concat
    printf("words:[%s], greet:[%s], strcat:[%s]\n", words, greet, greet_cat);

    // 扩展类型-枚举
    enum DAY {
        MON = 1, TUE, WEN, THU = 4, FRI, SAT, SUN  // 枚举类型的值默认连续,才可遍历
    };
    enum DAY e_day = MON;
    printf("enum day: %d, fri=[%d]\n", e_day, FRI);

    // 扩展类型-结构体
    struct UserInfoIn {
        int id;
        char name[20];
    };
    struct UserInfo user1, *user13;  // 使用, 指向结构体的指针
    struct UserInfo user12 = {10, "Hello"};  // 初始化赋值
    user1.id = 20;
    strcpy(user1.name, "hello world");

    // 结构体参数
    user13 = increase_user_id(&user12);  // 结构体传地址
    printf("user13.id=[%d, %d]\n", user13->id, (*user13).id);  // 结构体指针取值


    // 扩展类型-union共用体, 说明: union只能存取其中的一项
    union UserKeyIn {
        int id;
        char key;
    };
    union UserKey user2, *user3;
    user2.id = 15;
    printf("user2: id=>%d\n", user2.id);
    user2.key = 'C';
    printf("user2: key=>[%c], id=>[%d]\n", user2.key, user2.id);

    // 共用体传参
    user3 = decrease_user_id(&user2);  // 共用体传地址
    printf("user3: key=>[%c], id=>[%d]\n", user3->key, user3->id);

    // 位域, 精简版的结构体,节省内存
    struct Bs {
        unsigned a:4;
        unsigned  :4;    /* 空域,占位不可用 */
        unsigned b:4;    /* 从下一单元开始存放 */
        unsigned c:4;
    };
    struct Bs bs;

    // typedef定义
    typedef unsigned short TYPE_AGE;
    TYPE_AGE ty_a;  // TYPE_AGE ==> unsigned short
    typedef struct Students {
        int stu_no;
        char stu_name[20];
    } Student;
    Student student1;  // Student ==> struct Students

    // 指针
    int num_a = 10, *p_a = &num_a, *p_b;
    p_b = &num_a;
    printf("指针pa的地址为:[%p], 指针pb的值为:[%d]\n", p_a, *p_b);

    // 结构体指针
    /*struct UserInfo *p_user_1 = NULL;
    p_user_1->id = 22;
    strcpy(p_user_1->name, "hello");
    */

    // 函数指针->函数式
    int (*p_fun_max)(int , int) = & max;  // &可以省略
    int max_src = max(10, 20);
    int max_cp = p_fun_max(10, 20);
    int max_c = call_max(10, 20, p_fun_max);
    printf("max_src:[%d], max_cp:[%d], mac_c:[%d]\n", max_src, max_cp, max_c);


    // 输入/输出
    /*
    // scanf/printf,  使用char类型
    int sa;
    printf("input a int value: ");
    scanf("%d", &sa);
    printf("the value is [%d]\n", sa);

    // getchar/putchar, 使用int类型
    int sb;
    printf("input a char value: ");
    sb = getchar();
    printf("the value is [%c]\n", sb);
    putchar(sb); // 输出到stdout

    // gets() & puts()
    char gets_words[100];
    printf("enter words : ");
    gets(gets_words);  // 从stdin读取一行到缓冲区
    printf( "\nYou entered: ");
    puts(gets_words);  // 写入到 stdout
    printf("\n");
    */

    // 预定义宏
    printf("date:[%s]\ntime:[%s]\nfile:[%s]\nline:[%d]\nstdc:[%d]\n", __DATE__, __TIME__, __FILE__, __LINE__, __STDC__);

    // 强制类型转换
    int da = 3, db = 5; double dc; char dd = 'D';
    dc = (double)da / db;  // double
    dd = dd + da;  // int操作字符串
    printf("double dc:[%f], char dd:[%c]\n", dc, dd);

    // 错误和异常
    int test_errno = 2;
    fprintf(stderr, "测试错误: 错误码:[%d],错误内容:[%s]\n", test_errno, strerror(test_errno));  // stderr在stdout上方输出

    // 可变参数
    int sum_a;
    sum_a = sum_args(1, 2, 3, 4, 5);

    // 内存分配与回收
    char name[20];  // 静态分配
    char *book_name = (char *)malloc(20 * sizeof(char));  // 动态分配
    char *addr_name = (char *)calloc(20, sizeof(char));  // 分配+初始化
    // 调整内存
    book_name = (char *)realloc(book_name, 100 * sizeof(char));
    // 内存使用
    strcpy(book_name, "你好");  strcpy(addr_name, "c语言");
    printf("内存使用: [%s], [%s]", book_name, addr_name);
    // 内存回收
    free(book_name); free(addr_name);


    // 命令行参数: ./main name1 name2
    // int main(int argc, char *argv[])
    // argc=2,  argv[0]="name1" argv[2]="name2"

    printf("\n");
    return 0;
}
