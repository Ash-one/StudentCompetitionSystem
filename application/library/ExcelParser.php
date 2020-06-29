<?php

/**
 * @name ExcelParser
 * @author IceSolitary
 * @desc 解析上传excel的部件
 */
class ExcelParser
{
    public function init(){

    }

    public static function read($filePath)
    {
        require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';

        // Db_Mongodb::dropDatabase();

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        // 方法二
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        for ($i = 2 ; $i<count($sheetData);$i++){

            if($sheetData[$i]["D"]=="男") {
                $sheetData[$i]["D"] = '1';
            }
            elseif($sheetData[$i]["D"]=="女") {
                $sheetData[$i]["D"] = '0';
            }
            else{
                echo "sex_error";
            }

            // TODO: $sheetData[$i]["C"] 年级的转换

            // 插入 school 基础信息
            Dao_SchoolModel::getInstance()->uniqueInsert(['school_name'=>$sheetData[$i]["E"]]);
            $school_id = Dao_SchoolModel::getInstance()->queryOne(['school_name'=>$sheetData[$i]["E"]])["_id"];

            // 插入 student 基础信息
            $student_id = $sheetData[$i]["B"];
            if (Dao_StudentModel::getInstance()->queryOne(['student_id' => $student_id]) == null) {
                Dao_StudentModel::getInstance()->uniqueInsert([
                        'student_name'=>$sheetData[$i]["A"], 
                        'student_id' => $student_id,
                        'student_grade' => $sheetData[$i]["C"],
                        'student_sex' => $sheetData[$i]["D"],
                    ]
                );
            }
            $student_oid = Dao_StudentModel::getInstance()->queryOne(['student_id'=>$sheetData[$i]["B"]])["_id"];
            
            // 插入 competiton 基础信息
            $competition_name = $sheetData[$i]["H"];
            $competition_sTime = $sheetData[$i]["I"];
            if (Dao_CompetitionModel::getInstance()->queryOne(['competition_name'=>$competition_name, 'competition_start_time'=>$competition_sTime]) == null) {
                Dao_CompetitionModel::getInstance()->uniqueInsert([
                        'competition_name'=>$competition_name,
                        'competition_start_time'=>$competition_sTime, 
                        'competition_end_time'=>$sheetData[$i]["J"]
                    ]
                );
            }          
            $competition_id = Dao_CompetitionModel::getInstance()->queryOne(['competition_name'=>$competition_name, 'competition_start_time'=>$competition_sTime])["_id"];

            // 插入 match 基础信息
            $match_name = $sheetData[$i]["F"];
            if (Dao_MatchModel::getInstance()->queryOne(['match_name'=>$match_name, 'match_belong_competition'=>$competition_id]) == null) {
                Dao_MatchModel::getInstance()->uniqueInsert([
                        'match_name'=>$match_name,
                        'match_time'=>$sheetData[$i]["G"], 
                        'match_belong_competition'=>$competition_id
                    ]
                );
            }
            $match_id = Dao_MatchModel::getInstance()->queryOne(['match_name'=>$match_name, 'match_belong_competition'=>$competition_id])['_id'];

            // 插入 award 基础信息
            Dao_AwardModel::getInstance()->uniqueInsert([
                    'competition_object_id'=>$competition_id,
                    'match_object_id'=>$match_id, 
                    'award_type'=>$sheetData[$i]["L"],
                    'student_object_id'=>$student_oid,
                    'school_object_id'=>$school_id,
                    'award_rank'=>$sheetData[$i]["K"]
                ]
            );
            $award_id = Dao_AwardModel::getInstance()->queryOne([
                    'competition_object_id'=>$competition_id,
                    'match_object_id'=>$match_id, 
                    'student_object_id'=>$student_oid,
                ]
            )['_id'];

            // 插入关联信息

            Dao_SchoolModel::getInstance()->update(['_id'=>$school_id], ['$addToSet'=>['school_competition_details'=>$competition_id]]);
            Dao_SchoolModel::getInstance()->update(['_id'=>$school_id], ['$addToSet'=>['school_award_details'=>$award_id]]);
            Dao_SchoolModel::getInstance()->update(['_id'=>$school_id], ['$addToSet'=>['school_students'=>$student_oid]]);

            Dao_StudentModel::getInstance()->update(['_id'=>$student_oid], ['school_object_id'=>$school_id]);
            Dao_StudentModel::getInstance()->update(['_id'=>$student_oid], ['$addToSet'=>['student_competition_details'=>$competition_id]]);
            Dao_StudentModel::getInstance()->update(['_id'=>$student_oid], ['$addToSet'=>['student_award_details'=>$award_id]]);
            Dao_StudentModel::getInstance()->update(['_id'=>$student_oid], ['$addToSet'=>['student_match_details'=>$match_id]]);

            Dao_CompetitionModel::getInstance()->update(['_id'=>$competition_id], ['$addToSet'=>['competition_participating_schools'=>$school_id]]);
            Dao_CompetitionModel::getInstance()->update(['_id'=>$competition_id], ['$addToSet'=>['competition_participating_students'=>$student_oid]]);
            Dao_CompetitionModel::getInstance()->update(['_id'=>$competition_id], ['$addToSet'=>['competition_award_details'=>$award_id]]);
            Dao_CompetitionModel::getInstance()->update(['_id'=>$competition_id], ['$addToSet'=>['competition_match_items'=>$match_id]]);

            Dao_MatchModel::getInstance()->update(['_id'=>$match_id], ['$addToSet'=>['match_student_details'=>$student_oid]]);
        }

    }




}
