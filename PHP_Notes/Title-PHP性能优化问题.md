--------
# Title:PHP性能优化问题
### Author：Ron Lee  
### Date：2018/8/13
--------

## Part I：性能优化解析（难度从易到难）
1. PHP语言级的性能优化
2. PHP周边问题的性能优化
3. PHP语言自身分析优化 

## Part II :PHP自身性能注意事项
1. 多使用PHP自带函数
2. 纯字符串使用单引号
3. 减少文件IO操作
4. 减少外部网络服务请求
5. 少用PHP魔法函数
6. 拒绝使用错误抑制符号@
7. 可以用unset释放不适用的内存
8. 尽量少用正则表达式
9. 尽量将类的方法定义成static
10. 不适用require_once()，使用include时使用绝对路径
11. switch函数好于多个ifelse
12. 打开apache的mod_deflate可以提高网页浏览速度
13. 数据库使用完毕请关闭，避免使用长链接
14. 尽量使用PHP或者是Memcached等缓存系统，减少编译时间
15. i+=1的效率明显高于i=i+1
16. foreach效率更高，尽量避免while和for
17. 打开文件时使用file_put_content
18. PHP不要进行密集计算，可使用python解决
19. apache的ab工具可以检查网站性能
20. Apache解析一个PHP脚本的时间要比解析一个静态HTML页面慢2至10倍。尽量多用静态HTML页面，少用脚本
21. $row[’id’] 的速度是$row[id]的7倍
22. 优化Select SQL语句，在可能的情况下尽量少的进行Insert、Update操作
23. 请将PHP升级到PHP7
