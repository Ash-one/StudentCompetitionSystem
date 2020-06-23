<template>
  <div class="ActivityInfo">
    <div class="top">
      <div class="left_top">
        <a class="logo" herf="#">
          <img
            width="65px"
            height="50px"
            src="static/Images/cuc.jpg"
            alt="icon"
          />
        </a>
        <h2 class="title">竞赛活动平台</h2>
      </div>
      <div class="right_top">
        <i class="el-icon-message-solid" style="font-size:25px"></i>
      </div>
    </div>
    <div
      class="host_header"
      :style="{
        backgroundImage:
          'url(' + require('../../static/Images/person.jpg') + ')'
      }"
    >
      <div class="Acti_wrap">
        <div class="Acti_info">
          <div class="img">
            <el-image
              :src="src"
              style="width:80px height=80px"
              fit:fill
            ></el-image>
            <h3 style="margin-top:5px">{{year}} 年度</h3>
          </div>
          <div class="txt">
            <div class="name">
              <h3>{{name}}</h3>
              <h5 class="kind">举办时间:</h5>
              <p class="con_kind" style="width:120px">
                {{ ActiInfo[0].holdingtime }}
              </p>
              <h5 class="kind">举办状态:</h5>
              <p class="con_kind">{{ ActiInfo[0].statu }}</p>
              <h5 class="kind">活动类别:</h5>
              <p class="con_kind">{{ ActiInfo[0].kind }}</p>
              <h5 class="kind">包含项目:</h5>
              <p class="con_kind">{{ ActiInfo[0].items }}</p>
            </div>
          </div>
        </div>
        <div class="Acti_show">
          <img class="award" src="static/Images/award.png" />
          <h3 class="award_txt">竞 赛 项 目 数 据</h3>
        </div>
      </div>
    </div>
    <div class="wrap">
      <div class="row_box">
        <div class="row_main">
          <div class="data_title">
            <div style="float:left">竞赛数据详情</div>
          </div>
          <div class="row_tb">
            <div class="detail_data">
              <ul class="report_box">
                <li class="li_topBox">
                  <div class="report_list">
                    <div class="inline_block">
                      <i class="el-icon-tickets img_set"></i>
                    </div>
                    <div class="inline_block">
                      <h2 class="h2_set">
                        {{ ActiDataIndetail[0].num_matchs }}
                      </h2>
                      <p class="p_set">总项目数</p>
                    </div>
                  </div>
                </li>
                <li class="li_topBox">
                  <div class="report_list">
                    <div class="inline_block">
                      <i class="el-icon-school img_set"></i>
                    </div>
                    <div class="inline_block">
                      <h2 class="h2_set">
                        {{ ActiDataIndetail[0].num_schools }}
                      </h2>
                      <p class="p_set">总参与学校数</p>
                    </div>
                  </div>
                </li>
                <li class="li_topBox">
                  <div class="report_list">
                    <div class="inline_block">
                      <i class="el-icon-user img_set"></i>
                    </div>
                    <div class="inline_block">
                      <h2 class="h2_set">
                        {{ ActiDataIndetail[0].num_students }}
                      </h2>
                      <p class="p_set">总参与人数</p>
                    </div>
                  </div>
                </li>
                <li class="li_topBox">
                  <div class="report_list" style="border-right:0">
                    <div class="inline_block">
                      <i class="el-icon-trophy-1 img_set"></i>
                    </div>
                    <div class="inline_block">
                      <h2 class="h2_set">
                        {{ ActiDataIndetail[0].num_students }}
                      </h2>
                      <p class="p_set">总获奖人数</p>
                    </div>
                  </div>
                </li>
              </ul>
              <ul class="report_box" style="border-bottom:0">
                <li class="li_butoomBox">
                  <div class="report_list">
                    <div class="inline_block">
                      <img class="img_set" src="static/Images/male.png" />
                    </div>
                    <div class="inline_block">
                      <h2 class="h2_set">
                        {{ ActiDataIndetail[0].num_males }}
                      </h2>
                      <p class="p_set">参与男生人数</p>
                    </div>
                  </div>
                </li>
                <li class="li_butoomBox">
                  <div class="report_list" style="border-right:0">
                    <div class="inline_block">
                      <img class="img_set" src="static/Images/famale.png" />
                    </div>
                    <div class="inline_block">
                      <h2 class="h2_set">
                        {{ ActiDataIndetail[0].num_females }}
                      </h2>
                      <p class="p_set">参与女生人数</p>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row_box" style="height:620px">
        <div class="row_main" style="height:600px">
          <div class="data_title">
            <div style="float:left">竞赛项目详情</div>
          </div>
          <div class="ItemData">
            <el-table
              :data="ItemsData"
              :header-cell-style="{ 'text-align': 'center' }"
              :cell-style="{ 'text-align': 'center' }"
              stripe
              ref="singletable"
              highlight-current-row
              style="width: 100%"
              height="480px"
            >
              <el-table-column fixed type="index" width="50"> </el-table-column>
              <el-table-column
                prop="name"
                label="项目名称"
                width="200"
              ></el-table-column>
              <el-table-column
                prop="time"
                label="项目时间"
                width="200"
              ></el-table-column>
              <el-table-column
                prop="num_schools"
                label="参与学校数"
                width="150"
              ></el-table-column>
              <el-table-column
                prop="num_students"
                label="参与学生数"
                width="150"
              ></el-table-column>
              <el-table-column
                prop="num_males"
                label="男生人数"
                width="150"
              ></el-table-column>
              <el-table-column
                prop="num_females"
                label="女生人数"
                width="150"
              ></el-table-column>
            </el-table>
            <div class="ItemButtom">
              <el-pagination
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page="currentPage4"
                :page-sizes="[10, 25, 50, 100]"
                :page-size="10"
                layout="total, sizes, prev, pager, next, jumper"
                :total="400"
              >
              </el-pagination>
            </div>
          </div>
        </div>
      </div>
      <div class="row_box" style="height:620px">
        <div class="row_main" style="height:600px">
          <div class="data_title">
            <div style="float:left">竞赛学生详情</div>
          </div>
          <div class="ItemData">
            <el-table
              :data="ItemsStuData"
              :header-cell-style="{ 'text-align': 'center' }"
              :cell-style="{ 'text-align': 'center' }"
              stripe
              ref="singletable"
              highlight-current-row
              style="width: 100%"
              height="480px"
            >
              <el-table-column fixed type="index" width="50"> </el-table-column>
              <el-table-column
                prop="stu_name"
                label="学生姓名"
                width="150"
              ></el-table-column>
              <el-table-column
                prop="school_name"
                label="所在学校"
                width="200"
              ></el-table-column>
              <el-table-column
                prop="con_Id"
                label="全国学籍号"
                width="150"
              ></el-table-column>
              <el-table-column
                prop="name"
                label="项目名称"
                width="200"
              ></el-table-column>
              <el-table-column
                prop="award"
                label="奖项名次"
                width="150"
              ></el-table-column>
              <el-table-column
                prop="award_kind"
                label="奖项类别"
                width="150"
              ></el-table-column>
            </el-table>
          </div>
          <div class="ItemButtom">
            <el-pagination
              @size-change="handleSizeChange"
              @current-change="handleCurrentChange"
              :current-page="currentPage4"
              :page-sizes="[10, 25, 50, 100]"
              :page-size="10"
              layout="total, sizes, prev, pager, next, jumper"
              :total="400"
            >
            </el-pagination>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name:null,
      year:null,
      ActiInfo: [
        {
          year: 2020,
          holdingtime: "开始:2020.05.12  结束:2020.07.13",
          statu: "举办中",
          kind: "线上比赛",
          items: "巡线小车竞速,S弯无动力小车"
        }
      ],
      src: "static/Images/activity.png",
      ActiDataIndetail: [
        {
          num_matchs: 12,
          num_schools: 34,
          num_students: 234,
          num_awarding: 78,
          num_males: 84,
          num_females: 150
        }
      ],
      ItemsData: [
        {
          name: "巡线小车竞速",
          time: "2020.01.02",
          num_schools: 47,
          num_students: 120,
          num_males: 60,
          num_females: 60
        }
      ],
      ItemsStuData: [
        {
          stu_name: "宝宝",
          school_name: "中国传媒大学",
          con_Id: "10001",
          name: "巡线小车竞速",
          award: "一等奖",
          award_kind: "学生个人"
        }
      ]
    };
  },
  created() {
      this.name=this.$route.query.param1[0]
      this.year=this.$route.query.param1[1]
    }
};
</script>

<style scoped>
.ActivityInfo {
  height: 100%;
}
div {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
.top {
  position: fixed;
  z-index: 99999;
  width: 100%;
  top: 0;
  left: 0;
  background-color: #ffffff;
  height: 80px;
  box-sizing: border-box;
  border-bottom: 1px solid #dfe3e7;
}
.left_top {
  position: relative;
  float: left;
  width: 50%;
  height: fit-content;
}
.logo {
  position: absolute;
  top: 15px;
  left: 20px;
}
.title {
  position: absolute;
  left: 85px;
  top: 10px;
}
.right_top {
  position: relative;
  float: right;
  width: 50%;
  height: fit-content;
  padding-top: 30px;
}
.host_header {
  color: #ffffff;
  height: 420px;
  width: 100%;
  top: 80px;
  overflow: hidden;
}
.Acti_wrap {
  width: 85%;
  height: 400px;
  margin: 0 auto;
}
.Acti_info {
  width: 65%;
  height: 380px;
  float: left;
}
.Acti_show{
  width:35%;
  height: 380px;
  float: right;
}
.award{
  margin-top: 80px;
  margin-right: 150px;
  line-height: 60px;
  height: 150px;
}
.award_txt{
   margin-right: 150px;
}
.img {
  float: left;
  width: 40%;
  height: 200px;
  margin-top: 40px;
}
.txt {
  float: right;
  width: 60%;
  height: 340px;
  /*border: 1px solid #dfe3e7;
  box-shadow: 0 0 15px #4e4e4e;*/
  padding-left: 10px;
  margin-top: 12px;
}
.kind {
  text-align: left;
  font-size: 14px;
  color: #aaaaaa;
  height: fit-content;
  margin: auto 0;
  opacity: 0.6;
}
.con_kind {
  font-size: 16px;
  text-align: left;
  margin: 8px;
  height: fit-content;
}
.wrap {
  width: 80%;
  height: 100%;
  margin: 0 auto;
  margin-top: -80px;
}
.row_box {
  margin-top: 20px;
  height: 450px;
  background-color: #ffffff;
}
.row_main {
  padding: 20px;
  height: 430px;
}
.data_title {
  height: 44px;
  line-height: 24px;
  padding: 10px 0;
  padding-left: 20px;
  font-size: 16px;
  border-bottom: 1px solid #f3f3f3;
}
.row_tb {
  padding: 20px 0;
}
.report_box {
  list-style: none;
  display: block;
  height: 160px;
  padding: 0;
  border-bottom: 1px solid #f3f3f3;
}
.li_topBox {
  width: 25%;
  float: left;
  text-align: center;
}
.report_list {
  border-right: 1px solid #f3f3f3;
  overflow: hidden;
  margin: 30px 0;
}
.inline_block {
  display: inline-block;
  vertical-align: middle;
}
.img_set {
  line-height: 78px;
  height: 60px;
  float: left;
  margin-right: 8px;
  font-size: 30px;
  color: #5493ff;
}
.h2_set {
  margin-top: 20px;
  margin-bottom: 5px;
  color: #5493ff;
}
.p_set {
  margin-top: 5px;
  margin: 8px 0;
}
.li_butoomBox {
  width: 50%;
  float: left;
  text-align: center;
}
.ItemData {
  margin-left: 40px;
  margin-right: 40px;
}
.ItemButtom {
  margin-top: 25px;
}
</style>
