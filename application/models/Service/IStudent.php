<?php
/**
 * @name Service_IStudentModel
 * @desc Student Service 接口，为 StudentsController 提供服务，详见 API_doc
 * @author kuroki
 */
interface Service_IStudentModel {
    /**
     * 为 API: /students/overview 提供服务，返回所有 student 信息
     *      studentOverview: 一个键值对数组，其 keys: 
     *          name_stu, sex, name_school, grade, 
     *          id, num_cmpts, num_awards
     * @return array 一个 studentOverView 数组
     */
    public function getStudentOverview();

    /**
     * 为 API: /students/info/ 提供服务，返回由参数指定的 student 信息
     *      studentInfo: 一个键值对数组，其 keys:
     *          name_stu, sex, name_school, grade, 
     *          id, num_cmpts, num_matchs, num_awards,
     *          num_aw_person, num_aw_group
     *
     * @param int $id student 学号
     * @return array 一个 studentInfo
     */
    public function getStudentInfo($id);

    /**
     * 为 API: /students/detail/ 提供服务，返回由参数指定的 student 的所有 award 信息
     *      awardDetail: 一个键值对数组，其 keys:
     *          name_cmpt, year, state, holdingtime,
     *          name_match, award, award_type
     *
     * @param int $id student 学号
     * @return array 一个 awardDetail 数组
     */
    public function getStudentAwardsDetail($id);

    /**
     * 为 API: /students/chart/ 提供服务，返回由参数指定的 student 的按年度的统计信息
     *      yearDetail: 一个键值对数组，其 keys:
     *          year, num_cmpts, num_matchs,
     *          num_awards, num_aw_person, num_aw_group
     *
     * @param int $id student 学号
     * @return array 一个 awardDetail 数组
     */
    public function getStudentChartDataDetail($id);
}
