<?php
/**
 * @name Service_IPlatformModel
 * @desc Competion Service 接口，为 PlatformController 提供服务，详见 API_doc
 * @author kuroki
 */
interface Service_IPlatformModel {
    /**
     * 为 API: /platform/overview 提供服务，返回 platform（每年的统计） 信息
     *      yearOverview: 一个键值对数组，其 keys: 
     *          year, num_cmpts, num_matchs, num_stus,
     *          num_schools, num_males, num_females
     * 
     * @return array 一个 yearOverview 数组
     */
    public function getPlatformOverview();
}
