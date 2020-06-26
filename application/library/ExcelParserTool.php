<?php

/**
 * @name JsonController
 * @author IceSolitary
 * @desc 解析上传excel的部件
 */
class ExcelParser
{
    public function init(){

    }

    public static function read()
    {
        require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';

        $inputFileName = dirname(dirname(dirname(__FILE__))) . '/SCS基础数据表.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
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

            Dao_SchoolModel::getInstance()->update([ 'school_name'=>$sheetData[$i]["E"]], ['school_name'=>$sheetData[$i]["E"]], ['multi'=>false,'upsert'=>true]);
            $school_id = Dao_SchoolModel::getInstance()->queryOne(['school_name'=>$sheetData[$i]["E"]])["_id"];
//            echo $school_id."   ";
//            $student_doc = [ 'student_name'=>$sheetData[$i]["A"], 'student_id'=>$sheetData[$i]["B"], 'student_grade'=>$sheetData[$i]["C"], 'student_sex'=>$sheetData[$i]["D"]];
//
//            $student_doc2 = $student_doc + ['$addToSet'=>['school_object_id'=>$school_id]];
//
//            print_r($student_doc2) ;
//            echo "\n";
//            print_r($student_doc) ;

            Dao_StudentModel::getInstance()->update([ 'student_name'=>$sheetData[$i]["A"]], ['student_name'=>$sheetData[$i]["A"]], ['multi'=>false,'upsert'=>true]);
//            $student_id = Dao_StudentModel::getInstance()->queryOne(['student_name'=>$sheetData[$i]["A"]])["_id"];
//            echo $student_id."  \n";
//            Dao_CompetitionModel::getInstance()->update(['competition_name'=>$sheetData[$i]["H"], 'competition_start_time'=>$sheetData[$i]["I"], 'competition_end_time'=>$sheetData[$i]["J"]],['competition_name'=>$sheetData[$i]["H"], 'competition_start_time'=>$sheetData[$i]["I"], 'competition_end_time'=>$sheetData[$i]["J"]],['multi'=>false,'upsert'=>true]);
//            $competition_id = Dao_CompetitionModel::getInstance()->queryOne(['competition_name'=>$sheetData[$i]["H"]])["_id"];
//            Dao_MatchModel::getInstance()->update(['match_name'=>$sheetData[$i]["F"], 'match_time'=>$sheetData[$i]["G"], 'match_belong_competition'=>$competition_id],['match_name'=>$sheetData[$i]["F"], 'match_time'=>$sheetData[$i]["G"], 'match_belong_competition'=>$competition_id], ['multi'=>false,'upsert'=>true]);
//            $match_id = Dao_StudentModel::getInstance()->queryOne(['match_name'=>$sheetData[$i]["F"]])["_id"];
//            Dao_AwardModel::getInstance()->update(['competition_object_id'=>$competition_id,'match_object_id'=>$match_id,'award_type'=>$sheetData[$i]["L"],'student_object_id'=>$student_id,'school_object_id'=>$school_id,'award_rank'=>$sheetData[$i]["K"]],['competition_object_id'=>$competition_id,'match_object_id'=>$match_id,'award_type'=>$sheetData[$i]["L"],'student_object_id'=>$student_id,'school_object_id'=>$school_id,'award_rank'=>$sheetData[$i]["K"]], ['multi'=>false,'upsert'=>true]);
//            $Award_id = Dao_StudentModel::getInstance()->queryOne(['match_object_id'=>$match_id, 'student_object_id'=>$student_id])["_id"];
//
//            Dao_StudentModel::getInstance()->update(['$addToSet'=>['student_competition_details'=>$competition_id]]);
//            Dao_StudentModel::getInstance()->update(['$addToSet'=>['student_award_details'=>$Award_id]]);
//
//            Dao_SchoolModel::getInstance()->update(['$addToSet'=>['school_competition_details'=>$competition_id]]);
//            Dao_SchoolModel::getInstance()->update(['$addToSet'=>['school_award_details'=>$Award_id]]);
//            Dao_SchoolModel::getInstance()->update(['$addToSet'=>['school_students'=>$student_id]]);
//
//            Dao_MatchModel::getInstance()->update(['$addToSet'=>['match_student_details'=>$student_id]]);
//
//            Dao_CompetitionModel::getInstance()->update(['$addToSet'=>['competition_participating_schools'=>$school_id]]);
//            Dao_CompetitionModel::getInstance()->update(['$addToSet'=>['competition_participating_students'=>$student_id]]);
//            Dao_CompetitionModel::getInstance()->update(['$addToSet'=>['competition_award_details'=>$Award_id]]);
//            Dao_CompetitionModel::getInstance()->update(['$addToSet'=>['competition_match_items'=>$match_id]]);

        }

    }




}
