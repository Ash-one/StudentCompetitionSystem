<template>
  <div class="SchoolData">
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
    <div class="all_content">
      <div class="catalog">
        <div class="wrap_catalog">
          <div
            id="format"
            @mouseover="mouseOver(3)"
            @mouseleave="mouseLeave(3)"
            :style="active2"
          >
            <router-link class="leftTag" to="/">
              <i id="left_image" class="el-icon-box" style="font-size:18px"></i>
              <span>活 动 数 据</span>
            </router-link>
          </div>
          <div
            id="format"
            @mouseover="mouseOver(2)"
            @mouseleave="mouseLeave(2)"
            :style="active1"
          >
            <router-link class="leftTag" to="StudentData">
              <i
                id="left_image"
                class="el-icon-user"
                style="font-size:18px"
              ></i>
              <span>学 生 数 据</span>
            </router-link>
          </div>
          <div id="format" class="important">
            <router-link class="leftTag" to="SchoolData">
              <i
                id="left_image"
                class="el-icon-school"
                style="font-size:18px"
              ></i>
              <span>学 校 数 据</span>
            </router-link>
          </div>
          <div
            id="format"
            @mouseover="mouseOver(4)"
            @mouseleave="mouseLeave(4)"
            :style="active3"
          >
            <router-link class="leftTag" to="PlatData">
              <i
                id="left_image"
                class="el-icon-monitor"
                style="font-size:18px"
              ></i>
              <span>平 台 数 据</span>
            </router-link>
          </div>
          <div id="format"></div>
        </div>
      </div>
      <div class="content">
        <h3 class="c_title">学校数据</h3>

        <el-select
          class="select"
          style="width:90px"
          v-model="value"
          @visible-change="yearChange"
          filterable
          clearable="true"
          placeholder="ALL"
        >
          <el-option
            v-for="item in years"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          >
          </el-option>
        </el-select>
        <div class="import">
          <el-upload
            action
            accept=".xlsx,.xls"
            :auto-upload="false"
            :on-change="handle"
            :on-remove="handleRemove"
            :file-list="fileList"
          >
            <el-button type="success" style="width:100px">导入数据</el-button>'
          </el-upload>
        </div>
      </div>
      <div class="data">
        <el-table
          :data="tableData"
          stripe
          ref="singletable"
          highlight-current-row
          style="width: 100%"
          height="600"
        >
          <el-table-column fixed type="index" width="50"> </el-table-column>
          <el-table-column fixed prop="name" label="活动名称" width="150">
          </el-table-column>
          <el-table-column prop="year" label="年度" width="90">
          </el-table-column>
          <el-table-column prop="state" label="状态" width="90">
          </el-table-column>
          <el-table-column prop="time" label="举办时间" width="130">
          </el-table-column>
          <el-table-column prop="kind" label="活动类别" width="130">
          </el-table-column>
          <el-table-column prop="items" label="包含项目" width="130">
          </el-table-column>
          <el-table-column prop="sum" label="总人数" width="80">
          </el-table-column>
          <el-table-column prop="boy" label="男生人数" width="80">
          </el-table-column>
          <el-table-column prop="girl" label="女生人数" width="80">`
          </el-table-column>
        </el-table>
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
</template>
<script>
import xlsx from "xlsx";
import { readFile } from "../assets/utils";

export default {
  name: "SchoolData",
  data() {
    return {
      active1: "",
      active2: "",
      active3: "",
      years: [],
      value: 2020,
      fileList: [{ name: "", url: "" }],
      tableData: [
        {
          name: "中学线上运动会",
          year: "2020",
          state: "进行中",
          time: "开始:2020.05.12 结束:2020.07.13",
          kind: "线上竞赛",
          items: "游泳、仰卧起坐",
          sum: 24,
          boy: 12,
          girl: 12
        },
        {
          name: "中学线上运动会",
          year: "2020",
          state: "进行中",
          time: "开始:2020.05.12 结束:2020.07.13",
          kind: "线上竞赛",
          items: "游泳、仰卧起坐",
          sum: 24,
          boy: 12,
          girl: 12
        },
        {
          name: "中学线上运动会",
          year: "2020",
          state: "进行中",
          time: "开始:2020.05.12 结束:2020.07.13",
          kind: "线上竞赛",
          items: "游泳、仰卧起坐",
          sum: 24,
          boy: 12,
          girl: 12
        },
        {
          name: "中学线上运动会",
          year: "2020",
          state: "进行中",
          time: "开始:2020.05.12 结束:2020.07.13",
          kind: "线上竞赛",
          items: "游泳、仰卧起坐",
          sum: 24,
          boy: 12,
          girl: 12
        },
        {
          name: "中学线上运动会",
          year: "2020",
          state: "进行中",
          time: "开始:2020.05.12 结束:2020.07.13",
          kind: "线上竞赛",
          items: "游泳、仰卧起坐",
          sum: 24,
          boy: 12,
          girl: 12
        },
        {
          name: "中学线上运动会",
          year: "2020",
          state: "进行中",
          time: "开始:2020.05.12 结束:2020.07.13",
          kind: "线上竞赛",
          items: "游泳、仰卧起坐",
          sum: 24,
          boy: 12,
          girl: 12
        },
        {
          name: "中学线上运动会",
          year: "2020",
          state: "进行中",
          time: "开始:2020.05.12 结束:2020.07.13",
          kind: "线上竞赛",
          items: "游泳、仰卧起坐",
          sum: 24,
          boy: 12,
          girl: 12
        },
        {
          name: "中学线上运动会",
          year: "2020",
          state: "进行中",
          time: "开始:2020.05.12 结束:2020.07.13",
          kind: "线上竞赛",
          items: "游泳、仰卧起坐",
          sum: 24,
          boy: 12,
          girl: 12
        },
        {
          name: "中学线上运动会",
          year: "2020",
          state: "进行中",
          time: "开始:2020.05.12 结束:2020.07.13",
          kind: "线上竞赛",
          items: "游泳、仰卧起坐",
          sum: 24,
          boy: 12,
          girl: 12
        }
      ]
    };
  },
  methods: {
    yearChange() {
      for (var i = 2020; i >= 2010; i--) {
        this.years.push({ value: i, label: i });
      }
    },
    async handle(ev) {
      //判断是否有文件内容
      let file = ev.raw;
      if (!file) return;
      //读取数据
      let data = await readFile(File);
      let workbook = xlsx.read(data, { type: "binary" });
      worksheet = workbook.Sheets[workbook.SheetNames[0]];
      data = xlsx.utils.sheet_to_json(worksheet);
    },
    submit() {},
    beforeRemove(file, fileList) {
      return this.$confirm("确定移除 ${file.name}？");
    },
    handleRemove(file, fileList) {
      console.log(file, fileList);
    },
    mouseOver: function(num) {
      if (num == 2) {
        this.active1 = "background-color: #397dff";
      } else if (num == 3) {
        this.active2 = "background-color: #397dff";
      } else if (num == 4) {
        this.active3 = "background-color: #397dff";
      }
    },
    mouseLeave: function(num) {
      if (num == 2) {
        this.active1 = "background-color: #5493ff";
      } else if (num == 3) {
        this.active2 = "background-color: #5493ff";
      } else if (num == 4) {
        this.active3 = "background-color: #5493ff";
      }
    }
  }
};
</script>
<style scoped>
.SchoolData {
  padding: 100%;
  margin: 0;
  font-size: 14px;
  height: 100%;
  background-color: #f2f2f2;
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
.all_content {
  position: absolute;
  top: 80px;
  left: 0;
  right: 0;
  bottom: 0;
  overflow: hidden;
}
.catalog {
  position: fixed;
  left: 0;
  width: 175px;
  height: 100%;
}
.content {
  position: fixed;
  left: 175px;
  right: 0;
  top: 80px;
  height: 60px;
  background-color: #ffffff;
}
.wrap_catalog {
  width: 100%;
  height: 100%;
  background-color: #5493ff;
  font-size: 14px;
  float: left;
  /*background-image: url("/static/Images/sidebarBg.png");*/
}
#format {
  height: 50px;
  line-height: 50px;
  vertical-align: middle;
  border: 0;
  margin-bottom: 0;
  padding: 0;
  text-indent: 0;
}
.important {
  background: #397dff;
  position: relative;
}
.leftTag {
  text-align: center;
  color: #ffffff;
  padding: 0;
  text-indent: 0;
  height: 50px;
  line-height: 50px;
  display: block;
  text-decoration: none;
}
#left_image {
  margin: 0 15px 0 -10px;
}
.c_title {
  position: absolute;
  left: 30px;
}
.select {
  position: absolute;
  left: 120px;
  top: 10px;
}
.import {
  position: fixed;
  right: 60px;
  top: 90px;
  width: 60px;
}
.data {
  position: fixed;
  top: 160px;
  left: 280px;
  box-shadow: -7.829px 11.607px 21px 0px rgba(71, 95, 123, 0.2);
}
</style>
