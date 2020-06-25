<?php
/**
 * CompetitionModel
 * @author guoyi
 */
class Dao_CompetitionModel extends Db_Mongodb implements Service_ICompetitionModel{
    /**
     * Db_CompetitionModel constructor.
     */
    protected function __construct()
    {
        parent::__construct();

        //设置集合
        $this->collection = 'competition';
        //设置字段
        $this->fields = [
            'competition_name'=>'',
            'competition_start_time'=>'',
            'competition_end_time'=>'',
            'competition_participating_schools'=>[],
            'competition_participating_students'=>[],
            'competition_award_details'=>[],
            'competition_match_items'=>[]
        ];

        if($this->count() == 0){
            //空集合插入记录
            $this->insert(["competition_name"=>"北京市大学生运动会", "competition_start_time"=>"1580864400", "competition_end_time"=>"1581238800",
                "competition_participating_schools"=>[], "competition_participating_students"=>[], "competition_award_details"=>[], "competition_match_items"=>[]]);
        }

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
     * @return Dao_CompetitionModel
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Dao_CompetitionModel();
        }

        return self::$instance;
    }

    /**
     * 为 API: /competitions/overview 提供服务，返回所有 competiton 信息
     *      competitionOverview: 一个键值对数组，其 keys: 
     *          name_cmpt, year, state, holdingtime, 
     *          matchs, num_all, num_males, num_females
     * @return array 一个 competitionOverView 的数组
     */
    public function getCompetitonOverview() {
        $queryArray = self::$instance->query([]);

        $result = array();
        foreach ($queryArray as $item) {
            // 获取 competitonOverview 各个字段
            $competitionOverview = array();

            $competitionOverview['name_cmpt'] = $item['competition_name'];

            $competitionOverview['year'] = date("Y", $item['competition_start_time']);

            $competitionOverview['state'] = (time() > $item['competition_end_time']) ? "已结束": "举办中";

            $competitionOverview['holdingtime'] = date("Y.m.d", $item['competition_start_time']) . '-' . date("Y.m.d", $item['competition_end_time']);

            $matchStr = "";
            foreach ($item['competition_match_items'] as $id) {
                $matchStr .= $Dao_MatchModel::getInstance()->getInfoById($id, ['match_name'])['match_name'];
                $matchStr .= '，';
            }

            $studentCount = count($item['competition_participating_students']);
            $competitionOverview['num_all'] = $studentCount;

            $maleCount = 0;
            foreach ($item['competition_participating_students'] as $id) {
                $sex = Dao_StudentModel::getInstance()->getInfoById($id, ['student_sex'])['student_sex'];
                if ($sex == 1) {
                    $maleCount++;
                }
            }
            $competitionOverview['num_males'] = $maleCount;
            $competitionOverview['num_females'] = $studentCount - $maleCount;

            // 添加 competitionOverview
            $result[] = $competitionOverview;
        }

        return $result;
    }

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
    public function getCompetionInfo($name, $year) {
        // 获取对应的 competiton
        $queryArray = self::$instance->query(['competition_name' => $name]);
        $competiton = null;
        foreach ($queryArray as $item) {
            if (date("Y", $item['competition_start_time']) == $year) {
                $competiton = $item;
                break;
            }
        }

        if ($competiton == null) {
            return null;
        }

        // 获取 competitonOverview 各个字段
        $result = array();

        $result['year'] = date("Y", $item['competition_start_time']);

        $result['state'] = (time() > $item['competition_end_time']) ? "已结束": "举办中";

        $result['holdingtime'] = date("Y.m.d", $item['competition_start_time']) . '-' . date("Y.m.d", $item['competition_end_time']);

        $result['num_schools'] = count($item['competition_participating_schools']);

        $result['num_matchs'] = count($item['competition_match_items']);

        $studentCount = count($item['competition_participating_students']);
        $result['num_students'] = $studentCount;

        $maleCount = 0;
        foreach ($item['competition_participating_students'] as $id) {
            $sex = Dao_StudentModel::getInstance()->getInfoById($id, ['student_sex'])['student_sex'];
            if ($sex == 1) {
                $maleCount++;
            }
        }
        $result['num_males'] = $maleCount;
        $result['num_females'] = $studentCount - $maleCount;

        return $result;
    }

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
    public function getCompetitionMatchesDetail($name, $year) {
        // 获取对应的 competition
        $queryArray = self::$instance->query(['competition_name' => $name]);
        $competiton = null;
        foreach ($queryArray as $item) {
            if (date("Y", $item['competition_start_time']) == $year) {
                $competiton = $item;
                break;
            }
        }

        if ($competiton == null) {
            return null;
        }

        // 获取数据
        $matchIdArray = $competiton['competition_match_items'];
        $result = array();
        foreach ($matchIdArray as $id) {
            $match = Dao_MatchModel::getInstance()->queryOne(['_id' => $id]);
            $matchDetail = array();

            $matchDetail['name_match'] = $match['match_name'];

            $matchDetail['time_match'] = date("Y.m.d", $match['match_time']);

            $competitonInfo = Dao_CompetitionModel::getInstance()->getInfoById($matchDetail['match_belong_competition'], ['competition_participating_schools']);
            $matchDetail['num_schools'] = count($competitonInfo['competition_participating_schools']);

            $studentCount = count($match['match_student_details']);
            $matchDetail['num_students'] = $studentCount;

            $maleCount = 0;
            foreach ($match['match_student_details'] as $id) {
                $sex = Dao_StudentModel::getInstance()->getInfoById($id, ['student_sex'])['student_sex'];
                if ($sex == 1) {
                    $maleCount++;
                }
            }
            $matchDetail['num_males'] = $maleCount;
            $matchDetail['num_females'] = $studentCount - $maleCount;

            // 添加 matchDetail
            $result[] = $matchDetail;
        }

        return $result;
    }

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
    public function getCompetitionContestantsInfo($name, $year) {
        // 获取对应的 competition
        $queryArray = self::$instance->query(['competition_name' => $name]);
        $competiton = null;
        foreach ($queryArray as $item) {
            if (date("Y", $item['competition_start_time']) == $year) {
                $competiton = $item;
                break;
            }
        }

        if ($competiton === null) {
            return null;
        }

        // 获取信息
        $awardIdArray = $competition['competition_award_details'];
        $result = array();
        foreach ($awardIdArray as $id) {   
            $studentInfo = array();

            $award = Dao_AwardModel::getInstance()->queryOne(['_id' => $id]);
            $match = Dao_MatchModel::getInstance()->queryOne(['_id' => $award['match_object_id']]);
            $student = Dao_StudentModel::getInstance()->queryOne(['_id' => $award['student_object_id']]);
            $school = Dao_SchoolModel::getInstance()->queryOne(['_id' => $award['school_object_id']]);

            $studentInfo['name_match'] = $match['match_name'];
            $studentInfo['name_stu'] = $student['student_name'];
            $studentInfo['name_school'] = $school['school_name'];
            $studentInfo['id'] = $student['student_id'];
            $studentInfo['award'] = $award['award_rank'];
            
            switch ($award['award_type']) {
                case 0:
                    $studentInfo['award_type'] = "其他";
                    break;
                case 1:
                    $studentInfo['award_type'] = "个人";
                    break;
                case 2:
                    $studentInfo['award_type'] = "男子团体";
                    break;
                case 3:
                    $studentInfo['award_type'] = "女子团体";
                    break;
                case 4:
                    $studentInfo['award_type'] = "小学团体";
                    break;
                case 5:
                    $studentInfo['award_type'] = "初中团体";
                    break;
                case 6:
                    $studentInfo['award_type'] = "高中团体";
                    break;
                case 7:
                    $studentInfo['award_type'] = "大学团体";
                    break;               
                default:
                    break;
            }
            
            $result[] = $studentInfo;
        }

        return $result;
    }

    /**
     * 为 API: /upload 提供服务，将指定 excel 中的数据存入数据库中
     *
     * @param string $path excel 文件路径
     * @param string $fileName excel 文件名
     * @return null
     */
    public function saveData($path, $fileName) {
        
    }
}
?>