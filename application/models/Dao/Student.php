<?php
/**
 * StudentModel
 * @author guoyi
 */
class Dao_StudentModel extends Db_Mongodb implements Service_IStudentModel{
    protected static $instance = null;
    
    /**
     * Db_StudentModel constructor.
     */
    public function __construct()
    {
        parent::__construct();

        //设置集合
        $this->collection = 'student';
        //设置字段
        $this->fields = [
            'student_name'=>'',
            'student_id'=>'',
            'student_grade'=>'',
            'student_sex'=>'',
            'school_object_id'=>'',
            'student_competition_details'=>[],
            'student_award_details'=>[],
            'student_match_details'=>[]
        ];
    }

    /**
     * 实现单例模式（线程不安全）
     *
     * @return Dao_StudentModel
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Dao_StudentModel();
        }

        return self::$instance;
    }

    /**
     * 为 API: /students/overview 提供服务，返回所有 student 信息
     *      studentOverview: 一个键值对数组，其 keys: 
     *          name_stu, sex, name_school, grade, 
     *          id, num_cmpts, num_awards
     * @return array 一个 studentOverView 数组
     */
    public function getStudentOverview() {
        $queryArray = self::$instance->query([]);

        $result = array();
        foreach ($queryArray as $item) {
            // 获取 overview 各个字段
            $overview = array();

            $overview['name_stu'] = $item['student_name'];

            $overview['sex'] = $item['student_sex'] == 1 ? "男" : "女";

            $overview['name_school'] = Dao_SchoolModel::getInstance()->getInfoById($item['school_object_id'], ['school_name'])['school_name'];

            $overview['grade'] = $item['student_grade'];

            $overview['id'] = $item['student_id'];

            $overview['num_cmpts'] = count($item['student_competition_details']);

            $overview['num_awards'] = count($item['student_award_details']);

            // 添加 overview
            $result[] = $overview;
        }

        return $result;
    }

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
    public function getStudentInfo($id) {
        $item = self::$instance->queryOne(['student_id' => $id]);
        if ($item == null) {
            return null;
        }

        $result = array();

        $result['name_stu'] = $item['student_name'];

        $result['sex'] = $item['student_sex'] == 1 ? "男" : "女";

        $result['name_school'] = Dao_SchoolModel::getInstance()->getInfoById($item['school_object_id'], ['school_name'])['school_name'];

        $result['grade'] = $item['student_grade'];

        $result['id'] = $item['student_id'];

        $result['num_cmpts'] = count($item['student_competition_details']);

        $result['num_matchs'] = count($item['student_match_details']);

        $awardCount = count($item['student_award_details']);
        $result['num_awards'] = $awardCount;

        $studentAwardCount = 0;
        foreach ($item['student_award_details'] as $id) {
            $awardType = Dao_AwardModel::getInstance()->getInfoById($id, ['award_type'])['award_type'];
            if ($awardType == 1) {
                $studentAwardCount++;
            }
        }
        $result['num_aw_person'] = $studentAwardCount;
        $result['num_aw_group'] = $awardCount - $studentAwardCount;

        return $result;
    }

    /**
     * 为 API: /students/detail/ 提供服务，返回由参数指定的 student 的所有 award 信息
     *      awardDetail: 一个键值对数组，其 keys:
     *          name_cmpt, year, state, holdingtime,
     *          name_match, award, award_type
     *
     * @param int $id student 学号
     * @return array 一个 awardDetail 数组
     */
    public function getStudentAwardsDetail($id) {
        $item = self::$instance->queryOne(['student_id' => $id]);
        if ($item == null) {
            return null;
        }

        $result = array();
        foreach ($item['student_award_details'] as $id) {
            $awardDetail = array();
            $award = Dao_AwardModel::getInstance()->queryOne(['_id' => $id]);

            $competiton = Dao_CompetitionModel::getInstance()->queryOne(["_id" => $award['competition_object_id']]);
            $awardDetail['name_cmpt'] = $competiton['competition_name'];
            $awardDetail['year'] = date("Y", $competiton['competition_start_time']);
            $awardDetail['state'] = (time() > $competiton['competition_end_time']) ? "已结束": "举办中";
            $awardDetail['holdingtime'] = date("Y.m.d", $competiton['competition_start_time']) . '-' . date("Y.m.d", $competiton['competition_end_time']);

            $awardDetail['name_match'] = Dao_MatchModel::getInstance()->getInfoById($award['match_object_id'], ['match_name'])['match_name'];

            $awardDetail['award'] = $award['award_rank'];

            switch ($award['award_type']) {
                case 0:
                    $awardDetail['award_type'] = "其他";
                    break;
                case 1:
                    $awardDetail['award_type'] = "个人";
                    break;
                case 2:
                    $awardDetail['award_type'] = "男子团体";
                    break;
                case 3:
                    $awardDetail['award_type'] = "女子团体";
                    break;
                case 4:
                    $awardDetail['award_type'] = "小学团体";
                    break;
                case 5:
                    $awardDetail['award_type'] = "初中团体";
                    break;
                case 6:
                    $awardDetail['award_type'] = "高中团体";
                    break;
                case 7:
                    $awardDetail['award_type'] = "大学团体";
                    break;               
                default:
                    break;
            }
            
            $result[] = $awardDetail;
        }

        return $result;
    }

    /**
     * 为 API: /students/chart/ 提供服务，返回由参数指定的 student 的按年度的统计信息
     *      yearDetail: 一个键值对数组，其 keys:
     *          year, num_cmpts, num_matchs,
     *          num_awards, num_aw_person, num_aw_group
     *
     * @param int $id student 学号
     * @return array 一个 awardDetail 数组
     */
    public function getStudentChartDataDetail($id) {
        $student = self::$instance->queryOne(['student_id' => $id]);
        if ($student == null) {
            return null;
        }

        $result = array();
        $nowYear = intval(date('Y'));
        for ($i = 0; $i < 2; $i++) {
            $yearInfo = array();
            $year = $nowYear - $i;

            $yearInfo['year'] = $year;

            $cmptCount = 0;
            $matchCount = 0;
            $awCount = 0;
            $awPCount = 0;

            $cmptIdArray = $student['student_competition_details'];
            foreach ($cmptIdArray as $cmptId) {
                $item = Dao_CompetitionModel::getInstance()->queryOne(['_id'=>$cmptId]);
                if (date("Y", $item['competition_start_time']) == $year) {
                    $cmptCount++;
                }
            }

            $matchIdArray = $student['student_match_details'];
            foreach ($matchIdArray as $matchId) {
                $item = Dao_MatchModel::getInstance()->queryOne(['_id'=>$matchId]);
                if (date("Y", $item['match_time']) == $year) {
                    $matchCount++;
                }
            }

            $awIdArray = $student['student_award_details'];
            foreach ($awIdArray as $awId) {
                $award = Dao_AwardModel::getInstance()->queryOne(['_id'=>$awId]);
                $item = Dao_MatchModel::getInstance()->queryOne(['_id'=>$award['match_object_id']]);
                if (date("Y", $item['match_time']) == $year) {
                    $awCount++;

                    if ($award['award_type'] == 1) {
                        $awPCount++;
                    }
                }
            }

            $yearInfo['num_cmpts'] = $cmptCount;
            $yearInfo['num_matchs'] = $matchCount;
            $yearInfo['num_awards'] = $awCount;
            $yearInfo['num_aw_person'] = $awPCount;
            $yearInfo['num_aw_group'] = $awCount - $awPCount;

            $result[] = $yearInfo;
        }

        return $result;
    }
}
?>