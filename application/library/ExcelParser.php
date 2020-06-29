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

            if(!ExcelParser::verifyData($sheetData[$i],$i)){
                continue;
            }

            switch (intval($sheetData[$i]["C"])){
                case 11:
                    $sheetData[$i]["C"] = '小学一年级';
                    break;
                case 12:
                    $sheetData[$i]["C"] = '小学二年级';
                    break;
                case 13:
                    $sheetData[$i]["C"] = '小学三年级';
                    break;
                case 14:
                    $sheetData[$i]["C"] = '小学四年级';
                    break;
                case 15:
                    $sheetData[$i]["C"] = '小学五年级';
                    break;
                case 16:
                    $sheetData[$i]["C"] = '小学六年级';
                    break;
                case 21:
                    $sheetData[$i]["C"] = '初中一年级';
                    break;
                case 22:
                    $sheetData[$i]["C"] = '初中二年级';
                    break;
                case 23:
                    $sheetData[$i]["C"] = '初中三年级';
                    break;
                case 31:
                    $sheetData[$i]["C"] = '高中一年级';
                    break;
                case 32:
                    $sheetData[$i]["C"] = '高中二年级';
                    break;
                case 33:
                    $sheetData[$i]["C"] = '高中三年级';
                    break;
                case 41:
                    $sheetData[$i]["C"] = '大学一年级';
                    break;
                case 42:
                    $sheetData[$i]["C"] = '大学二年级';
                    break;
                case 43:
                    $sheetData[$i]["C"] = '大学三年级';
                    break;
                case 44:
                    $sheetData[$i]["C"] = '大学四年级';
                    break;
                default:
                    echo "数据格式错误";
            }

            // 插入 school 基础信息
            Dao_SchoolModel::getInstance()->uniqueInsert(['school_name'=>$sheetData[$i]["E"]]);
            $school_id = Dao_SchoolModel::getInstance()->queryOne(['school_name'=>$sheetData[$i]["E"]])["_id"];

            // 插入 student 基础信息
            $student_id = (string)$sheetData[$i]["B"];
            Dao_StudentModel::getInstance()->uniqueInsert([
                    'student_name'=>$sheetData[$i]["A"], 
                    'student_id' => $student_id,
                    'student_grade' => $sheetData[$i]["C"],
                    'student_sex' => $sheetData[$i]["D"],
                ]
            );
            $student_oid = Dao_StudentModel::getInstance()->queryOne(['student_id'=>$student_id])["_id"];
            
            // 插入 competiton 基础信息
            $competition_name = $sheetData[$i]["H"];
            $competition_sTime = intval($sheetData[$i]["I"]);
            if (Dao_CompetitionModel::getInstance()->queryOne(['competition_name'=>$competition_name, 'competition_start_time'=>$competition_sTime]) == null) {
                Dao_CompetitionModel::getInstance()->uniqueInsert([
                        'competition_name'=>$competition_name,
                        'competition_start_time'=>$competition_sTime, 
                        'competition_end_time'=>intval($sheetData[$i]["J"])
                    ]
                );
            }          
            $competition_id = Dao_CompetitionModel::getInstance()->queryOne(['competition_name'=>$competition_name, 'competition_start_time'=>$competition_sTime])["_id"];

            // 插入 match 基础信息
            $match_name = $sheetData[$i]["F"];
            if (Dao_MatchModel::getInstance()->queryOne(['match_name'=>$match_name, 'match_belong_competition'=>$competition_id]) == null) {
                Dao_MatchModel::getInstance()->uniqueInsert([
                        'match_name'=>$match_name,
                        'match_time'=>intval($sheetData[$i]["G"]), 
                        'match_belong_competition'=>$competition_id
                    ]
                );
            }
            $match_id = Dao_MatchModel::getInstance()->queryOne(['match_name'=>$match_name, 'match_belong_competition'=>$competition_id])['_id'];

            // 插入 award 基础信息
            Dao_AwardModel::getInstance()->uniqueInsert([
                    'competition_object_id'=>$competition_id,
                    'match_object_id'=>$match_id, 
                    'award_type'=>intval($sheetData[$i]["L"]),
                    'student_object_id'=>$student_oid,
                    'school_object_id'=>$school_id,
                    'award_rank'=>intval($sheetData[$i]["K"])
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

    //判断整个字符串是否匹配正则式的函数
    public static function pregMatchTotalStr($reg,$str){
        $is_match = preg_match($reg,$str,$return);
        if($is_match && strlen($return[0]) == strlen($str)){
            return 1;
        } else {
            return 0;
        }
    }

    //判断字符串是否为空
    public static function is_Null($str){
        if($str == null){
            return 1;
        } else {
            return 0;
        }

    }

    public static function verifyData($dataArray,$row){

        //用于验证的正则式
        $regStudentID = '([0-9]{5,11})';
        $regGrade = '(1[1-6]|2[1-3]|3[1-3]|4[1-4])';
        $regSex = '(0|1)';
        $regTime = '([0-9]{0,10})';
        $regAwardRank = '([0-9]{0,})';
        $regAwardType = '([1-7])';

        if(self::is_Null($dataArray['A'])){
            Db_Mongodb::log("row".$row.":name字段不符合数据规范,将跳过插入本条记录");
            return false;
        }

        if(!self::pregMatchTotalStr($regStudentID,$dataArray['B'])){
            Db_Mongodb::log("row".$row.":student_id字段不符合数据规范,将跳过插入本条记录");
            return false;
        }

        if(!self::pregMatchTotalStr($regGrade,$dataArray['C'])){
            Db_Mongodb::log("row".$row.":student_grade字段不符合数据规范,将跳过插入本条记录");
            return false;
        }

        if(!self::pregMatchTotalStr($regSex,$dataArray['D'])){
            Db_Mongodb::log("row".$row.":student_sex字段不符合数据规范,将跳过插入本条记录");
            return false;
        }

        if(self::is_Null($dataArray['E'])){
            Db_Mongodb::log("row".$row.":school_name字段不符合数据规范,将跳过插入本条记录");
            return false;
        }

        if(self::is_Null($dataArray['F'])){
            Db_Mongodb::log("row".$row.":match_name字段不符合数据规范,将跳过插入本条记录");
            return false;
        }

        if(!self::pregMatchTotalStr($regTime,$dataArray['G'])){
            Db_Mongodb::log("row".$row.":match_time字段不符合数据规范,将跳过插入本条记录");
            return false;
        }

        if(self::is_Null($dataArray['H'])){
            Db_Mongodb::log("row".$row.":competition_name字段不符合数据规范,将跳过插入本条记录");
            return false;
        }

        if(!self::pregMatchTotalStr($regTime,$dataArray['I'])){
            Db_Mongodb::log("row".$row.":competition_start_time字段不符合数据规范,将跳过插入本条记录");
            return false;
        }

        if(!self::pregMatchTotalStr($regTime,$dataArray['J'])){
            Db_Mongodb::log("row".$row.":competition_end_time字段不符合数据规范,将跳过插入本条记录");
            return false;
        }

        if(!self::pregMatchTotalStr($regAwardRank,$dataArray['K'])){
            Db_Mongodb::log("row".$row.":award_rank字段不符合数据规范,将跳过插入本条记录");
            return false;
        }

        if(!self::pregMatchTotalStr($regAwardType,$dataArray['L'])){
            Db_Mongodb::log("row".$row.":award_type字段不符合数据规范,将跳过插入本条记录");
            return false;
        }

        return true;

    }

}
