<?php
/**
 * @category Markshust
 * @package Markshust_Sortcssjs
 * @author Mark Shust <mark@shust.com>
 */
class Markshust_Sortcssjs_Block_Page_Html_Head extends Mage_Page_Block_Html_Head
{
    /**
     * Add HEAD Item
     *
     * Allowed types:
     *  - js
     *  - js_css
     *  - skin_js
     *  - skin_css
     *  - rss
     *
     * @param string $type
     * @param string $name
     * @param string $params
     * @param string $if
     * @param string $cond
     * @return Mage_Page_Block_Html_Head
     */
    public function addItem($type, $name, $params=null, $if=null, $cond=null)
    {
        if (is_numeric($params)) {
            $sort = $params;
            $params = null;
        } else {
            $sort = (isset($this->_data['items']) ? count($this->_data['items']): 0) + 5000;
        }
        
        if ($type==='skin_css' && empty($params)) {
            $params = 'media="all"';
        }
        $this->_data['items'][$type.'/'.$name] = array(
            'type'   => $type,
            'name'   => $name,
            'params' => $params,
            'if'     => $if,
            'cond'   => $cond,
            'sort'   => $sort,
       );
       return $this;
    }
    
    /**
     * Get HEAD HTML with CSS/JS/RSS definitions
     * (actually it also renders other elements, TODO: fix it up or rename this method)
     *
     * @return string
     */
    public function getCssJsHtml()
    {
        foreach ($this->_data['items'] as $itemKey => $itemValue) {
            $sortedItems[$itemKey] = $itemValue['sort'];
        }
        array_multisort($sortedItems, SORT_NUMERIC, $this->_data['items']);
        array_multisort($this->_data['items'], SORT_STRING, $sortedItems);

        return parent::getCssJsHtml();
    }
}
