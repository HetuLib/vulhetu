<?php
/**
 * @version   $Id: actionsearch_class.php 1 8:26 2010年7月12日 $
 * @package   DedeCMS.Administrator
 * @founder   IT柏拉图, https://weibo.com/itprato
 * @author    DedeCMS团队
 * @copyright Copyright (c) 2007 - 2021, 上海卓卓网络科技有限公司 (DesDev, Inc.)
 * @license   http://help.dedecms.com/usersguide/license.html
 * @link      http://www.dedecms.com
 */
class ActionSearch
{
    public $keyword;
    public $asarray = array();
    public $result = array();

    //初始化系统
    public function ActionSearch($keyword)
    {
        $this->asarray = $this->GetSearchstr();
        $this->keyword = $keyword;
    }

    public function GetSearchstr()
    {
        include_once dirname(__FILE__) . "/inc/inc_action_info.php";
        return is_array($actionSearch) ? $actionSearch : array();
    }

    public function search()
    {
        $this->searchkeyword();
        return $this->result;
    }

    /**
     *  遍历功能配置项进行关键词匹配
     *
     * @return void
     */
    public function searchkeyword()
    {
        $i = 0; //数组序列索引
        foreach ($this->asarray as $key => $value) {
            //对二级项目进行匹配
            if (is_array($this->asarray[$key]['soniterm'])) {
                foreach ($this->asarray[$key]['soniterm'] as $k => $val) {
                    //进行权限判断
                    if (TestPurview($val['purview'])) {
                        //如果有操作权限
                        if ($this->_strpos($val['title'], $this->keyword) !== false || $this->_strpos($val['description'], $this->keyword) !== false) {
                            //一级项目匹配
                            $this->result[$i]['toptitle'] = $this->redColorKeyword($this->asarray[$key]['toptitle']);
                            $this->result[$i]['title'] = $this->redColorKeyword($this->asarray[$key]['title']);
                            $this->result[$i]['description'] = $this->redColorKeyword($this->asarray[$key]['description']);
                            //二级项目匹配
                            $this->result[$i]['soniterm'][] = $this->redColorKeyword($val);
                        }
                    }
                }
            }
            $i++;
        }
    }

    /**
     *  加亮关键词
     *
     * @access public
     * @param  string $text 关键词
     * @return string
     */
    public function redColorKeyword($text)
    {
        if (is_array($text)) {
            foreach ($text as $key => $value) {
                if ($key == 'title' || $key == 'description') {
                    //仅对title,description进行数组替换
                    $text[$key] = str_replace($this->keyword, '<font color="red">' . $this->keyword . '</font>', $text[$key]);
                }
            }
        } else {
            $text = str_replace($this->keyword, '<font color="red">' . $this->keyword . '</font>', $text);
        }
        return $text;
    }

    public function _strpos($string, $find)
    {
        if (function_exists('stripos')) {
            return stripos($string, $find);
        }

        return strpos($string, $find);
    }
}