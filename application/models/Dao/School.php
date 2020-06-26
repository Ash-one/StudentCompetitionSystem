<?php
/**
 * SchoolModel
 * @author guoyi
 */
class Dao_SchoolModel extends Db_Mongodb implements Service_ISchoolModel {
    /**
     * Db_SchoolModel constructor.
     */
    public function __construct()
    {
        parent::__construct();

        //设置集合
        $this->collection = 'school';
        //设置字段
        $this->fields = [
            'school_name'=>'',
            'school_competition_details'=>[],
            'school_award_details'=>[],
            'school_students'=>[]
        ];

//        if($this->count() == 0){
//            //空集合插入记录
//            $this->insert(["school_name"=>"中国传媒大学", "school_competition_details"=>[], "school_award_details"=>[],
//                "school_students"=>[]]);
//        }

        //查询结果
        // $filter = [];
        // $result = $this->query($filter);
        // foreach ($result as $document) {
        //     print_r($document);
        // }
    }

    /**
     * 实现单例模式（线程不安全）
     *
     * @return Dao_SchoolModel
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Dao_SchoolModel();
        }

        return self::$instance;
    }

    /**
     * 为 API: /schools/overview 提供服务，返回所有 school 信息
     *      schoolOverview: 一个键值对数组，其 keys: 
     *          name_school, num_cmpts, num_awards,
     *          num_aw_stu, num_aw_person, num_aw_group
     * 
     * @return array 一个 schoolOverView 数组
     */
    public function getSchoolOverview() {
        $queryArray = self::$instance->query([]);

        $result = array();
        foreach ($queryArray as $item) {
            // 获取 overview 各个字段
            $overview = array();

            $overview['name_school'] = $item['school_name'];

            $overview['num_cmpts'] = count($item['school_competition_details']);

            $awardCount = count($item['school_award_details']);
            $overview['num_awards'] = $awardCount;

            // TODO: num_aw_stu ???

            foreach ($item['school_award_details'] as $id) {
                $awardType = Dao_AwardModel::getInstance()->getInfoById($id, ['award_type'])['award_type'];
                if ($awardType == 1) {
                    $studentAwardCount++;
                }
            }
            $overview['num_aw_person'] = $studentAwardCount;
            $overview['num_aw_group'] = $awardCount - $studentAwardCount;

            // 添加 overview
            $result[] = $overview;
        }

        return $result;
    }

    /**
     * 为 API: /schools/info/ 提供服务，返回由参数指定的 school 信息
     *      schoolInfo: 一个键值对数组，其 keys:
     *          num_cmpts, num_stus, num_awards
     * 
     * @param string $name school 名字
     * @return array 一个 schoolInfo
     */
    public function getSchoolInfo($name) {
        $item = self::$instance->queryOne(['school_name' => $name]);

        if ($item === null) {
            return null;
        }
        
        $result = array();
        $all = array();
        $byYear = array();

        // 获取 all 数据
        $all['num_cmpts'] = count($item['school_competition_details']);

        $all['num_stus'] = count($item['school_students']);

        $awardCount = count($item['school_award_details']);
        $all['num_awards'] = $awardCount;

        // TODO: num_aw_stu ???

        foreach ($item['school_award_details'] as $id) {
            $awardType = Dao_AwardModel::getInstance()->getInfoById($id, ['award_type'])['award_type'];
            if ($awardType == 1) {
                $studentAwardCount++;
            }
        }
        $all['num_aw_person'] = $studentAwardCount;
        $all['num_aw_group'] = $awardCount - $studentAwardCount;

        // 添加 all
        $result['All'] = $all;

        // 获取 byYear 数据
        $nowYear = intval(date('Y'));
        for ($i = 0; $i < 2; $i++) {
            $yearInfo = array();
            $year = $nowYear - $i;

            $yearInfo['year'] = $year;

            $cmptCount = 0;
            foreach ($item['school_competition_details'] as $id) {
                if (date("Y", Dao_CompetitionModel::getInstance()->getInfoById($id, ['competition_start_time'])) == $year) {
                    $cmptCount++;
                }
            }
            $yearInfo['num_cmpts'] = $cmptCount;

            $awCount = 0;
            $personAwCount = 0;
            foreach ($item['school_award_details'] as $id) {
                $aw = Dao_AwardModel::getInstance()->queryOne(['_id' => $id]);
                $awCmpt = Dao_CompetitionModel::getInstance()->getInfoById($aw['competition_object_id'], ['competition_start_time']);
                if (date("Y", $awCmpt['competition_start_time']) == $year) {
                    $awCount++;

                    if ($aw['award_type'] == 1) {
                        $personAwCount++;
                    }
                }
            }
            $yearInfo['num_awards'] = $awCount;
            $yearInfo['num_aw_person'] = $personAwCount;
            $yearInfo['num_aw_group'] = $awCount - $personAwCount;

            $byYear[] = $yearInfo;
        }

        // 添加 byYear
        $result['ByYear'] = $byYear;

        return $result;
    }

    /**
     * 为 API: /schools/detail/ 提供服务，返回由参数指定的 school 的所有学生 award 信息
     *      schoolAwardDetail: 一个键值对数组，其 keys:
     *          name_stu, name_cmpt, year,
     *          name_match, award, award_type
     *
     * @param string $name school 名字
     * @return array 一个 schoolAwardDetail 数组
     */
    public function getSchoolAwardsDetail($name) {
        $stuArray = self::$instance->queryOne(['school_name' => $name])['school_students'];

        if ($stuArray === null) {
            return null;
        }

        $result = array();
        foreach ($stuArray as $id) {
            $student = Dao_StudentModel::getInstance()->queryOne(['_id' => $id]);

            $stuAwardArray = $student['student_award_details'];
            foreach ($stuAwardArray as $aw_id) {
                $detail = array();

                $award = Dao_AwardModel::getInstance()->queryOne(['_id' => $aw_id]);
                $match = Dao_MatchModel::getInstance()->queryOne(['_id' => $award['match_object_id']]);
                $cmpt = Dao_CompetitionModel::getInstance()->queryOne(['_id' => $match['match_belong_competition']]);

                $detail['name_stu'] = $student['student_name'];
                $detail['name_cmpt'] = $cmpt['competition_name'];
                $detail['year'] = date("Y", $cmpt['competition_start_time']);
                $detail['name_match'] = $match['match_name'];
                $detail['award'] = $award['award_rank'];
                
                switch ($award['award_type']) {
                    case 0:
                        $detail['award_type'] = "其他";
                        break;
                    case 1:
                        $detail['award_type'] = "个人";
                        break;
                    case 2:
                        $detail['award_type'] = "男子团体";
                        break;
                    case 3:
                        $detail['award_type'] = "女子团体";
                        break;
                    case 4:
                        $detail['award_type'] = "小学团体";
                        break;
                    case 5:
                        $detail['award_type'] = "初中团体";
                        break;
                    case 6:
                        $detail['award_type'] = "高中团体";
                        break;
                    case 7:
                        $detail['award_type'] = "大学团体";
                        break;               
                    default:
                        break;
                }

                $result[] = $detail;
            }
        }

        return $result;
    }
}
?>