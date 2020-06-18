# API 接口设计参考文档

## 目录
#### - [竞赛数据接口](#竞赛数据)
#### - [学生数据接口](#学生数据)
-- [一级界面接口](#学生数据一级界面)
-- [二级界面接口](#学生数据二级界面)
#### - [学校数据接口](#学校数据)
-- [一级界面接口](#学校数据一级界面)
-- [二级界面接口](#学校数据二级界面)
#### - [平台数据接口](#平台数据)
#### - [状态码](#状态码)




## 竞赛数据

接口地址：http://api.gy5461.xyz/competitios/search 
支持格式：json  
请求方法：*GET*  
请求示例： 
http://api.gy5461.xyz/competitios/search 
http://api.gy5461.xyz/competitios/search/year/2019 
http://api.gy5461.xyz/competitios/search/keyword/cuc 
http://api.gy5461.xyz/competitios/search/year/2019/keyword/cuc 


- 请求参数： 

|  参数名称     |   类型     |    必填    |  说明            |
|   ----       |  :----:   |  :----:   |  :----:          |
|   year       |   string  |    N      |  年份             |
|   keyword    |  string   |    N      |  未知的搜索栏字符串 |
 

- 响应内容： 

|   参数名称        |   类型      | 说明  |
|   ----           |   :----:   | ----  |
|   name_cmpt      |   string   |   竞赛名称                    |
|   year           |   string   |   年份                        |
|   state          |   string   |   状态：进行中or已结束          | 
|   holdingtime    |   string   |   举办时间：开始：XXXX.XX.XX，结束：- |
|   category       |   string   |   竞赛类别：线上竞赛or线下竞赛        |
|   matchs         |   string   |   包含项目：项目名称之间用全角分号分隔  |
|   num_all        |   int      |   总人数          |
|   num_male       |   int      |   男生人数        |
|   num_female     |   int      |   女生人数        |




---
## 学生数据
### 学生数据一级界面

接口地址：http://api.gy5461.xyz/students/search/ 
支持格式：json  
请求方法：*GET* 
请求示例： 
http://api.gy5461.xyz/students/search/ 
http://api.gy5461.xyz/students/search/year/2019 
http://api.gy5461.xyz/students/search/keyword/Kevin 
http://api.gy5461.xyz/students/search/year/2019/keyword/Kevin 


- 请求参数： 

| 参数名称  |  类型    | 必填    |   说明          |
| ----    |   ----   | :----: |      ----       |
|   year  |  string  |    N   | 年份             |
| keyword |  string  |    N   | 未知的搜索栏字符串 |


- 响应内容： 

|   参数名称    |   类型     | 说明            |
|   :----      |   :----:  | ----           |
|   name       |   string  |   学生姓名       |
|   sex        |   string  |   男or女        |
|   school     |   string  |   学校名称       |
|   grade      |   string  |   年级          |
|   studentid  |   string  |   学号          |
|   num_cmpts  |   int     |   总参加竞赛次数  |
|   num_awards |    int    |   总获奖次数     |

### 学生数据二级界面
接口地址：http://api.gy5461.xyz/students/query/ 
支持格式：json  
请求方法：*GET*  
请求示例： 
http://api.gy5461.xyz/students/query/name/Kevin 
http://api.gy5461.xyz/students/query/name/Kevin/keyword/一等奖 


- 请求参数： 

|  参数名称  |  类型     | 必填    | 说明               |
|   ----    |  :----:  | :----: | ----               |
|   name    |  string  |   Y    |  学生姓名           |
|   keyword |  string  |   N    |  未知的搜索栏字符串   |

- 响应内容： 

|   参数名称        |   类型      | 说明                     |
|   ----           |   :----:   | ----                     |
|   name_cmpt      |   string   |   竞赛名称                |
|   year           |   string   |   年份                    |
|   state          |   string   |   进行中or已结束           |
|   holdingtime    |   string   |   开始：XXXX.XX.XX，结束：- |
|   category       |   string   |   线上竞赛or线下竞赛        |
|   match          |   string   |   项目名称                |
|   type           |   string   |   项目类别                |
|   award          |   string   |   获奖情况                |


----
## 学校数据
### 学校数据一级界面
接口地址：http://api.gy5461.xyz/schools/search 
支持格式：json  
请求方法：*GET*  
请求示例：
http://api.gy5461.xyz/schools/search/ 
http://api.gy5461.xyz/schools/search/year/2019 
http://api.gy5461.xyz/schools/search/keyword/传媒 
http://api.gy5461.xyz/schools/search/year/2019/keyword/大学 


- 请求参数： 

| 参数名称  |   类型    |  必填   | 说明            |
|   ----   |   ----   | :----: | ----            |
|  year    |  string  |  N     |    年份          |
|  keyword |  string  |  N     | 未知的搜索栏字符串 |


- 响应内容： 

|   参数名称           |   类型      | 说明           |
|   ----              |   :----:   | ----           |
|   school            |   string   |  学校名称       |
|   num_cmpts         |   int      |  总参加竞赛次数   |
|   num_awards        |   int      |  总获奖次数      |
|   num_aw_stu        |   int      |  总获奖学生人次   |
|   num_aw_person     |   int      |  总个人奖数      |
|   num_aw_group      |   int      |  总团体奖数      |

### 学校数据二级界面
接口地址：http://api.gy5461.xyz/schools/query 
支持格式：json  
请求方法：*GET*  
请求示例： 
http://api.gy5461.xyz/schools/query/school/CUC 
http://api.gy5461.xyz/schools/query/school/CUC/keyword/大学 


- 请求参数： 

| 参数名称  |   类型    |  必填   | 说明            |
|   ----   |   ----   | :----: | ----            |
|  school  |  string  |  Y     | 学校名称         |
|  year    |  string  |  N     | 年份             |
|  keyword |  string  |  N     | 未知的搜索栏字符串 |


- 响应内容： 

|   参数名称     |   类型      | 说明     |
|   ----        |   :----:   | ----    |
|   name        |   string   | 学生姓名  |
|   name_cmpt   |   string   | 竞赛名称  |
|   match       |   string   | 项目名称  |
|   award       |   string   | 获奖情况  |
|   award_type  |   string   | 奖项类别  |

---
## 平台数据

接口地址：http://api.gy5461.xyz/platform/search 
支持格式：json  
请求方法：*GET*   
请求示例： 
http://api.gy5461.xyz/platform/search/ 
http://api.gy5461.xyz/platform/search/year/2019 


- 请求参数： 

|  参数名称  |   类型    |  必填   | 说明      |
|   ----    |   ----   | :----: | ----      |
|   year    |  string  |   N    |           |


- 响应内容： 

|   参数名称         |   类型     | 说明   |
|   ----            |  :----:   | ----  |
|   num_cmpts       |   int     | 总竞赛活动数      |
|   num_stus        |   int     | 总参与学生人次    |
|   num_schools     |   int     | 总参与学校数      |
|   num_males       |   int     | 总男生数         |
|   num_females     |   int     | 总女生数         |
|   num_aw_males    |   int     | 总获奖男生数      |
|   num_aw_females  |   int     | 总获奖女生数      |

---
## 状态码

