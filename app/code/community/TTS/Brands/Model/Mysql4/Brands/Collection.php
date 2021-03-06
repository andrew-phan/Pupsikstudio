<?php
class TTS_Brands_Model_Mysql4_Brands_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        //parent::__construct();
        $this->_init('brands/brands');
    }

    public function toOptionArray($emptyLabel = ' ', $returnOptions = false)
    {
        $options = $this->_toOptionArray('brands_id', 'name', array('title'=>'title', 'image'=>'image', 'status'=>'status', 'filler'=>'filler',));
        if ($returnOptions) {
        	sort($options);
        	return $options;
        }
        $sort = array();
        foreach ($options as $index=>$data) {
			$sort[$data['title']] = $data['value'];
        }

        ksort($sort);
        $options = array(0=>'');
        foreach ($sort as $label=>$value) {
            $options[] = array(
               'value' => $value,
               'label' => $label
            );
        }

        if (count($options)>0 && $emptyLabel !== false) {
            array_unshift($options, array('value'=>'', 'label'=>$emptyLabel));
        }

        return $options;
    }

	public function getImgById($id){
		$this->getSelect()
			->where("brands_id=?",$id);
		return $this;
	}
}