<?php
/**
 * @name Service_PlatformModel
 * @desc Platfrom Service 实现类，为 PlatformController 提供服务，详见 API_doc
 * @author kuroki
 */
class Service_PlatformModel implements Service_IPlatformModel{
    /**
     * 为 API: /platform/overview 提供服务，返回 platform（每年的统计） 信息
     *      yearOverview: 一个键值对数组，其 keys: 
     *          year, num_cmpts, num_matchs, num_stus,
     *          num_schools, num_males, num_females
     * 
     * @return array 一个 yearOverview 数组
     */
    public function getPlatformOverview() {
        $result = array();

        $cmptArray = Dao_CompetitionModel::getInstance()->query([]);
        $matchArray = Dao_MatchModel::getInstance()->query([]);

        $nowYear = intval(date('Y'));
        for ($i = 0; $i < 2; $i++) {
            $yearInfo = array();
            $year = $nowYear - $i;

            $yearInfo['year'] = $year;

            $cmptCount = 0;
            $matchCount = 0;
            $stuCount = 0;
            $maleCount = 0;
            $scCount = 0;
            $schoolIdArray = array();
            foreach ($cmptArray as $cmpt) {
                if (date("Y", $cmpt['competition_start_time']) == $year) {
                    $cmptCount++;

                    foreach ($cmpt['competition_match_items'] as $matchid) {
                        $matchCount++;

                        $match = Dao_MatchModel::getInstance()->queryOne(['_id'=>$matchid]);
                        foreach ($match['match_student_details'] as $stuid) {
                            $stuCount++;

                            $student = Dao_StudentModel::getInstance()->queryOne(['_id'=>$stuid]);
                            if ($student['student_sex'] == 1) {
                                $maleCount++;
                            }
                        }
                    }
                    
                    foreach ($cmpt['competition_participating_schools'] as $scid) {
                        if (!in_array($scid, $schoolIdArray)) {
                            $schoolIdArray[] = $scid;
                            $scCount++;
                        }
                    }
                }
            }


            $yearInfo['num_cmpts'] = $cmptCount;
            $yearInfo['num_matchs'] = $matchCount;
            $yearInfo['num_stus'] = $stuCount;
            $yearInfo['num_schools'] = $scCount;
            $yearInfo['num_males'] = $maleCount;
            $yearInfo['num_females'] = $stuCount - $maleCount;

            $result[] = $yearInfo;
        }

        return $result;
    }
}