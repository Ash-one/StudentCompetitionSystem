# API 接口设计参考文档

## 目录

#### - [上传文件接口](#上传文件接口)
#### - [竞赛数据接口](#竞赛数据)
+ [一级界面接口](#竞赛数据一级界面)
+ [二级界面接口](#竞赛数据二级界面)
#### - [学生数据接口](#学生数据)
+ [一级界面接口](#学生数据一级界面)
+ [二级界面接口](#学生数据二级界面)
#### - [学校数据接口](#学校数据)
+ [一级界面接口](#学校数据一级界面)
+ [二级界面接口](#学校数据二级界面)
#### - [平台数据接口](#平台数据)
#### - [状态码](#状态码)


## 上传文件接口
接口地址：http://api.gy5461.xyz/upload   
支持格式：json  
请求方法：*POST*  
请求示例：  
http://api.gy5461.xyz/upload 



---
## 竞赛数据
### 竞赛数据一级界面
接口地址：http://api.gy5461.xyz/competitions/overview   
支持格式：json  
请求方法：*GET*  
请求示例：     
http://api.gy5461.xyz/competitions/overview    


- 响应内容： 

|   参数名称        |   类型      | 说明  |
|   ----           |   :----:   | ----  |
|   name_cmpt      |   string   |   竞赛名称                    |
|   year           |   string   |   年份                        |
|   state          |   string   |   状态：进行中or已结束          | 
|   holdingtime    |   string   |   举办时间：XXXX.XX.XX-XXXX.XX.XX |
|   matchs         |   string   |   包含项目：项目名称之间用全角分号分隔  |
|   num_all        |   int      |   总人数          |
|   num_male       |   int      |   男生人数        |
|   num_female     |   int      |   女生人数        |

- JSON响应示例：
```
{
    "status": "0",
    "msg"   : "ok",
    "result": [
        {
            "name_cmpt" : "全国大学生工程训练赛",
            "year"      : "2020",
            "state"     : "已结束",
            "holdingtime":"2020.01.01-2020.02.01",
            "matchs"    : "巡线小车竞速；S弯无动力小车",
            "num_all"   : "114",
            "num_male"  : "50",
            "num_female": "64"
        },
        {
            "name_cmpt" : "全国高中生工程训练赛",
            "year"      : "2020",
            "state"     : "已结束",
            "holdingtime":"2020.01.02-2020.02.02",
            "matchs"    : "巡线小车竞速；S弯无动力小车",
            "num_all"   : "114",
            "num_male"  : "50",
            "num_female": "64"
        }
    ]
}
```
### 竞赛数据二级界面

接口功能：指定竞赛的统计信息，通常只请求一次  
接口地址：http://api.gy5461.xyz/competitions/info   
支持格式：json  
请求方法：*GET*  
请求示例：     
http://api.gy5461.xyz/competitions/info/name/全国大学生工程训练赛/year/2019    

- 请求参数： 

|  参数名称     |   类型     |    必填    |  说明            |
|   ----       |  :----:   |  :----:   |  :----:          |
|   name       |  string   |    Y      |  竞赛名称         |
|   year       |  string   |    Y      |  年份             |

- 响应内容： 

|   参数名称        |   类型      | 说明          |
|   ----           |   :----:   | ----         |
|   year           |   string   |   年份        |
|   state          |   string   |   举办状态     |
|   holdingtime    |   string   |   举办时间：XXXX.XX.XX-XXXX.XX.XX|
|   num_schools    |   int      |   总参赛学校数 | 
|   num_matchs     |   int      |   包含项目数   |
|   num_students   |   int      |   总参赛人数   |
|   num_males      |   int      |   男生数      |
|   num_females    |   int      |   女生数      |


- JSON响应示例:
```
{
    "status" : "0",
    "msg"    : "ok",
    "result" :
        {
            "year":"2020",
            "state" : "已结束",
            "holdingtime"  : "2020.01.01-2020.02.01",
            "num_schools"  : 60，
            "num_matchs"   : 12,
            "num_students" : 233,
            "num_males"    : 150,
            "num_females"  : 83
        }
}
```


接口功能：指定竞赛的全部项目详情  
接口地址：http://api.gy5461.xyz/competitions/detail/     
支持格式：json  
请求方法：*GET*  
请求示例：     
http://api.gy5461.xyz/competitions/detail/name/全国大学生工程训练赛      
http://api.gy5461.xyz/competitions/detail/name/全国大学生工程训练赛/year/2019  
     


- 请求参数： 

|  参数名称  |  类型     | 必填    | 说明               |
|   ----    |  :----:  | :----: | ----               |
|   name    |  string  |   Y    |  竞赛名称           |
|   year    |  string  |    Y   |  年份              |


- 响应内容： 

|   参数名称         |   类型      | 说明          |
|   ----            |   :----:   | ----         |
|   name_match      |   string   |   项目名称    |
|   time_match      |   string   |   项目时间    |
|   num_schools     |   int      |   参与学校数   |
|   num_students    |   int      |   参与学生数   |
|   num_males       |   int      |   男生数      |
|   num_females     |   int      |   女生数      |

- JSON响应示例:
```
{
    "status" : "0",
    "msg"    : "ok",
    "result" : [
        {
            "name_match" : "巡线小车竞速",
            "time_match" : "2020.01.02",
            "num_schools"  : 23,
            "num_students" : 120,
            "num_males"   : 60,
            "num_females" : 60
        },
        {
            "name_match" : "S弯无动力小车",
            "time_match" : "2020.01.02",
            "num_schools"  : 23,
            "num_students" : 12,
            "num_males"   : 6,
            "num_females" : 6
        }
    ]
}
```

接口功能：参与指定竞赛的全部学生详情（参赛人员详情）  
接口地址：http://api.gy5461.xyz/competitions/contestant/     
支持格式：json  
请求方法：*GET*  
请求示例：     
http://api.gy5461.xyz/competitions/contestant/


- 响应内容： 

|   参数名称         |   类型      | 说明          |
|   ----            |   :----:   | ----         |
|   name_match      |   string   |   项目名称    |
|   name_stu        |   string   |   学生姓名      |
|   name_school     |   string   |   学校名称      |
|   id              |   string   |   学生ID       |
|   award           |   string   |   获奖情况      |
|   award_type      |   string   |   奖项类别      |

- JSON响应示例：
```
{
    "status" : "0",
    "msg"    : "ok",
    "result" : [
        {
            "name_match" : "划水比赛",
            "name_stu"  : "Kevin",
            "name_school" : "中国家里蹲大学",
            "id" : "201911143030",
            "award" : "一等奖",
            "award_type": "学生个人"
        },
        {
            "name_match" : "摸鱼比赛",
            "name_stu"  : "Franklin",
            "name_school" : "中国家外蹲大学",
            "id" : "201911143029",
            "award" : "二等奖",
            "award_type": "学生个人"
        }
    ]
}
```






---
## 学生数据
### 学生数据一级界面

接口地址：http://api.gy5461.xyz/students/overview/    
支持格式：json  
请求方法：*GET*     
请求示例：    
http://api.gy5461.xyz/students/overview/     

- 响应内容： 

|   参数名称    |   类型     | 说明            |
|   :----      |   :----:  | ----           |
|   name_stu   |   string  |   学生姓名       |
|   sex        |   string  |   男or女        |
|   name_school|   string  |   学校名称       |
|   grade      |   string  |   年级          |
|   id         |   string  |   学号          |
|   num_cmpts  |   int     |   总参加竞赛次数  |
|   num_awards |    int    |   总获奖次数     |

- JSON响应示例：
```
{
    "status" : "0",
    "msg"    : "ok",
    "result" : [
        {
            "name_stu" : "Kevin",
            "sex"  : "男",
            "name_school" : "中国家里蹲大学",
            "grade" : "大学一年级",
            "id" : "20191143066",
            "num_cmpts" : 66,
            "num_awards": 100
        },
        {
            "name_stu" : "Aoligay",
            "sex"  : "男",
            "name_school" : "中国家外蹲大学",
            "grade" : "大学一年级",
            "id" : "20191145141",
            "num_cmpts" : 88,
            "num_awards": 89
        }
    ]
}
```

### 学生数据二级界面

接口功能：指定学生的情况统计，通常只请求一次  
接口地址：http://api.gy5461.xyz/students/info/     
支持格式：json  
请求方法：*GET*  
请求示例：     
http://api.gy5461.xyz/students/info/id/201911143030          


- 请求参数： 

|  参数名称  |  类型     | 必填    | 说明         |
|   ----    |  :----:  | :----: | ----         |
|   id      |  string  |   Y    |  学生id      |

- 响应内容： 

|   参数名称        |   类型      | 说明          |
|   ----           |   :----:   | ----         |
|   name_stu       |  string    |  姓名         |
|   sex            |  string    |  性别         |
|   name_school    |  string    |  学校         |
|   grade          |  string    |  年级         |
|   id             |  string    |  ID          |
|   num_cmpts      |  int       |  总参加竞赛数  |
|   num_matchs     |  int       |  总参加项目数  |
|   num_award      |  int       |  总获奖数     |
|   num_aw_person  |  int       |  总获个人奖数  |
|   num_aw_group   |  int       |  总获团体奖数  |

- JSON响应示例:
```
{
    "status" : "0",
    "msg"    : "ok",
    "result" :
        {
            "name_stu" : "Kevin",
            "sex" : "男", 
            "name_school"    : "中国家里蹲大学",
            "grade"     : "大学一年级",
            "id":"201911143030",
            "num_cmpts" : 60,
            "num_matchs": 36,
            "num_award" : 66,
            "num_aw_person": 30,
            "num_aw_group": 36
        }
}
```


接口功能：指定学生的全部奖项详情  
接口地址：http://api.gy5461.xyz/students/detail/     
支持格式：json  
请求方法：*GET*  
请求示例：     
http://api.gy5461.xyz/students/detail/id/201911143030
     


- 请求参数： 

|  参数名称  |  类型     | 必填    | 说明               |
|   ----    |  :----:  | :----: | ----               |
|   id      |  string  |   Y    |  学生id             |


- 响应内容： 

|   参数名称        |   类型      | 说明                     |
|   ----           |   :----:   | ----                     |
|   name_cmpt      |   string   |   竞赛名称                |
|   year           |   string   |   年份                    |
|   state          |   string   |   进行中or已结束           |
|   holdingtime    |   string   |   举办时间：XXXX.XX.XX-XXXX.XX.XX|
|   name_match     |   string   |   项目名称                |
|   award          |   string   |   获奖情况                |
|   award_type     |   string   |   项目类别                |

- JSON响应示例:
```
{
    "status" : "0",
    "msg"    : "ok",
    "result" :[
        {
            "name_cmpt" : "全国大学生扯淡锦标赛",
            "year"      : "2020",
            "state"     : "已结束",
            "holdingtime" : "2020.01.01-2020.01.03",
            "name_match"     : "嘴强王者挑战",
            "award"     : "三等奖",
            "award_type": "个人"
        },
        {
            "name_cmpt" : "全国大学生工程训练赛",
            "year"      : "2020",
            "state"     : "已结束",
            "holdingtime" : "2020.01.01-2020.01.03",
            "name_match"     : "巡线小车竞速",
            "award"     : "三等奖",
            "award_type": "团队"
        }
    ]
}

```


----
## 学校数据
### 学校数据一级界面
接口地址：http://api.gy5461.xyz/schools/overview    
支持格式：json  
请求方法：*GET*  
请求示例：   
http://api.gy5461.xyz/schools/overview/     


- 响应内容： 

|   参数名称           |   类型      | 说明           |
|   ----              |   :----:   | ----           |
|   name_school       |   string   |  学校名称       |
|   num_cmpts         |   int      |  总参加竞赛次数   |
|   num_awards        |   int      |  总获奖次数      |
|   num_aw_stu        |   int      |  总获奖学生人次   |
|   num_aw_person     |   int      |  总个人奖数      |
|   num_aw_group      |   int      |  总团体奖数      |

- JSON响应示例:
```
{
    "status" : "0",
    "msg"    : "ok",
    "result" :[
        {
            "name_school" : "中国加里敦大学",
            "num_cmpts" : 10,
            "num_awards"    : 14,
            "num_aw_stu"    : 26,
            "num_aw_person" : 10,
            "num_aw_group"  : 16,
        },
        {
            "name_school" : "中国加外敦大学",
            "num_cmpts" : 20,
            "num_awards"    : 24,
            "num_aw_stu"    : 26,
            "num_aw_person" : 11,
            "num_aw_group"  : 16,
        }
    ]
}
```

### 学校数据二级界面

接口功能：指定学校数据统计信息，通常只请求一次   
接口地址：http://api.gy5461.xyz/schools/info   
支持格式：json  
请求方法：*GET*  
请求示例：    
http://api.gy5461.xyz/schools/info/name/中国加里敦大学      


- 请求参数： 

| 参数名称  |   类型    |  必填   | 说明       |
|   ----   |   ----   | :----: | ----       |
|  name    |  string  |  Y     | 学校名称    |


- 响应内容： 

|   参数名称     |   类型      | 说明           |
|   ----        |   :----:   | ----          |
|   num_cmpts   |   int      |  总参赛次数     |
|   num_stus    |   int      |  总参赛学生人次  |
|   num_awards  |   int      |  总获奖人次     |

- JSON响应示例:
```
{
    "status" : "0",
    "msg"    : "ok",
    "result" :
        {
            "num_cmpts"      : 23 ,
            "num_stus"       : 80 ,
            "num_awards"     : 80
        }
}
```




接口功能：指定学校数据详情(学生参赛获奖情况)  
接口地址：http://api.gy5461.xyz/schools/detail   
支持格式：json  
请求方法：*GET*  
请求示例：    
http://api.gy5461.xyz/schools/detail/name/CUC       


- 请求参数： 

| 参数名称  |   类型    |  必填   | 说明            |
|   ----   |   ----   | :----: | ----            |
|  name    |  string  |  Y     | 学校名称         |


- 响应内容： 

|   参数名称     |   类型      | 说明     |
|   ----        |   :----:   | ----    |
|   name_stu    |   string   | 学生姓名  |
|   name_cmpt   |   string   | 竞赛名称  |
|   year        |   string   |   年份   |
|   name_match  |   string   | 项目名称  |
|   award       |   string   | 获奖情况  |
|   award_type  |   string   | 奖项类别  |


- JSON响应示例:
```
{
    "status" : "0",
    "msg"    : "ok",
    "result" :[
        {
            "name_stu"       : "Kevin",
            "name_cmpt"  : "中国扯淡竞赛",
            "year"       : "2019",
            "name_match"      : "嘴强王者",
            "award"      : "一等奖",
            "award_type" : "个人",
        },
        {
            "name_stu"       : "Franklin",
            "name_cmpt"  : "中国扯淡竞赛",
            "year"       : "2018",
            "name_match"      : "嘴强王者",
            "award"      : "一等奖",
            "award_type" : "个人",
        }
    ]
}
```



---
## 平台数据

接口地址：http://api.gy5461.xyz/platform/overview    
支持格式：json  
请求方法：*GET*   
请求示例：    
http://api.gy5461.xyz/platform/overview/     


- 响应内容： 

|   参数名称         |   类型     | 说明            |
|   ----            |  :----:   | ----            |
|   year            |   string  | 年份             |
|   num_cmpts       |   int     | 总竞赛活动数      |
|   num_matchs      |   int     | 总项目数         |
|   num_stus        |   int     | 总参与学生人次    |
|   num_schools     |   int     | 总参与学校数      |
|   num_males       |   int     | 总男生数         |
|   num_females     |   int     | 总女生数         |



- JSON响应示例:
```
{
    "status" : "0",
    "msg"    : "ok",
    "result" :[
        {
            "year"            : "2020",
            "num_cmpts"       : "200",
            "num_matchs"      : "800",
            "num_stus"        : "10000",
            "num_schools"     : "211",
            "num_males"       : "6000",
            "num_females"     : "4000"
        },
        {
            "year"            : "2019",
            "num_cmpts"       : "199",
            "num_matchs"      : "877",
            "num_stus"        : "10000",
            "num_schools"     : "985",
            "num_males"       : "6666",
            "num_females"     : "3334"
        },
    ]
}
```


---
## 状态码
status |  状态说明
----   |  ----
0      |  ok
1      |  error


### 系统错误码
code       |    error_msg
----       |    ----
101        |    接口目前不可用


### API 错误码
code       |    error_msg
----       |    ----
201        |    必需参数为空
202        |    搜索结果不存在
203        |    json编码错误

- 响应示例：
```
{
    "status" : "1",
    "code"   : "201",
    "msg" : "必需参数为空"
}
```










