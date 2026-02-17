<?php  
// require_once vc_path_dir('SHORTCODES_DIR', 'vc-posts-grid.php');
if( class_exists('WPBakeryShortCode')){
	class WPBakeryShortCode_Wpo_All_Products extends WPBakeryShortCode {

		public function getListQuery(){
			$list_query = array();
			$types = explode(',', $this->atts['show_tab']);
			foreach ($types as $type) {
				$list_query[$type] = $this->getTabTitle($type);
			}
			return $list_query;
		}

		public function getTabTitle($type){
			switch ($type) {
				case 'recent':
					return array('title'=>__('Latest Products',TEXTDOMAIN),'title_tab'=>__('Latest',TEXTDOMAIN));
				case 'featured_product':
					return array('title'=>__('Featured Products',TEXTDOMAIN),'title_tab'=>__('Featured',TEXTDOMAIN));
				case 'top_rate':
					return array('title'=> __('Top Rated Products',TEXTDOMAIN),'title_tab'=>__('Top Rated', TEXTDOMAIN));
				case 'best_selling':
					return array('title'=>__('BestSeller Products',TEXTDOMAIN),'title_tab'=>__('BestSeller',TEXTDOMAIN));
				case 'on_sale':
					return array('title'=>__('Special Products',TEXTDOMAIN),'title_tab'=>__('Special',TEXTDOMAIN));
			}
		}
	}
}