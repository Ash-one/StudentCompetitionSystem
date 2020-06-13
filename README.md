# StudentCompetitionSystem

## staff 
- **web** 
>     韩丽萍 许烨同 张宇航 田可安 
- **back-end** 
>     郭颐 刘明洋 葛启明 黄海玲
- **API** 
>     关旭增
- **test** 
>     崔明

## ussage
### 服务器配置（以 nginx 为例）
``` ini
# $YOUR_PATH 为 StudentCompetitionSystem 所在的绝对路径
root $YOUR_PATH/StudentCompetitionSystem/public/;

index index.php index.html index.htm;

if (!-e $request_filename) {
    rewrite ^/(.*)  /index.php?$1 last;
}

location / {
    try_files $uri $uri/ =404;
}

# pass PHP scripts to FastCGI server
#
location ~ \.php$ {
    fastcgi_pass 127.0.0.1:9000; 
    fastcgi_index index.php; 
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;		
    fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;

    include fastcgi_params;
}
```

### 关于public/index.php的改动

* 先在本地安装好mongodb数据库及php mongodb扩展，第一次运行时取消插入数据部分代码的注释
* 第二次及以后注释掉插入数据部分代码，避免重复插入

