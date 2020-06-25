<?php
/**
 * @name Service_ICompetitionModel
 * @desc Competion Service 接口，为 CompetitionsController 提供服务，详见 API_doc
 * @author kuroki
 */
interface Service_ICompetitionModel {
    /**
     * 为 API: /competitions/overview 提供服务，返回所有 competiton 信息
     *      competitionOverview: 一个键值对数组，其 keys: 
     *          name_cmpt, year, state, holdingtime, 
     *          matchs, num_all, num_males, num_females
     * @return array 一个 competitionOverView 的数组
     */
    public function getCompetitonOverview();

    /**
     * 为 API: /competitions/info/ 提供服务，返回由参数指定的 competition 信息
     *      competitionInfo: 一个键值对数组，其 keys:
     *          year, state, holdingtime, num_schools,
     *          num_matchs, num_students, num_males, num_females
     *
     * @param string $name competiton 的名字
     * @param int $year competition 举办的开始年份
     * @return array 一个 competitonInfo 
     */
    public function getCompetionInfo($name, $year);

    /**
     * 为 API: /competitions/detail/ 提供服务，返回由参数指定的 competition 的所有 match 信息
     *      matchDetail: 一个键值对数组，其 keys:
     *          name_match, time_match, num_schools,
     *          num_students, num_males, num_females
     *
     * @param string $name competiton 的名字
     * @param int $year competition 举办的开始年份
     * @return array 一个 matchDetail 数组
     */
    public function getCompetitionMatchesDetail($name, $year);

    /**
     * 为 API: /competitions/contestant/ 提供服务，返回由参数指定的 competition 的所有 student 信息
     *      studentInfo: 一个键值对数组，其 keys:
     *          name_match, name_stu, name_school,
     *          id, award, award_type
     *
     * @param string $name competiton 的名字
     * @param int $year competition 举办的开始年份
     * @return array 一个 studentInfo 数组
     */
    public function getCompetitionContestantsInfo($name, $year);
}
