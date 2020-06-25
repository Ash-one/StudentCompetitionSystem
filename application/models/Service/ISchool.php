<?php
/**
 * @name Service_ISchoolModel
 * @desc School Service 接口，为 SchoolsController 提供服务，详见 API_doc
 * @author kuroki
 */
interface Service_ISchoolModel {
    /**
     * 为 API: /schools/overview 提供服务，返回所有 school 信息
     *      schoolOverview: 一个键值对数组，其 keys: 
     *          name_school, num_cmpts, num_awards,
     *          num_aw_stu, num_aw_person, num_aw_group
     * 
     * @return array 一个 schoolOverView 数组
     */
    public function getSchoolOverview();

    /**
     * 为 API: /schools/info/ 提供服务，返回由参数指定的 school 信息
     *      schoolInfo: 一个键值对数组，其 keys:
     *          num_cmpts, num_stus, num_awards
     * 
     * @param string $name school 名字
     * @return array 一个 schoolInfo
     */
    public function getSchoolInfo($name);

    /**
     * 为 API: /schools/detail/ 提供服务，返回由参数指定的 school 的所有学生 award 信息
     *      schoolAwardDetail: 一个键值对数组，其 keys:
     *          name_stu, name_cmpt, year,
     *          name_match, award, award_type
     *
     * @param string $name school 名字
     * @return array 一个 schoolAwardDetail 数组
     */
    public function getSchoolAwardsDetail($name);
}
