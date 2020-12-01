window.addEventListener('load', function(){
	var AVAIBLE_ITEM_ROW = 3.0; // 4.0
	var START_ROW = 2;
	var INCREASE_ROW = 2;
	var category_group = document.getElementsByClassName('category_group')[0];
	var children_category_group_items = category_group.children;

	// initialz hide blocks
	if ( Math.ceil(children_category_group_items.length / AVAIBLE_ITEM_ROW) > START_ROW ) {
		for (var i = children_category_group_items.length - 1; i >= START_ROW*AVAIBLE_ITEM_ROW; i--) {
			var curItem = children_category_group_items[i];
			curItem.classList.toggle('hide_block');
		}
	}

	var group_show_button = document.getElementsByClassName('group_show')[0];

	group_show_button.addEventListener("click", function(){
		var category_group_hidden = document.querySelectorAll('.category_group,.hide_block');

		for (var i = 0; i < Math.min(category_group_hidden.length, AVAIBLE_ITEM_ROW * INCREASE_ROW + 1); i++) {
			var curItem = category_group_hidden[i];
			curItem.classList.toggle('hide_block');
		}

		var category_group_hidden_new = document.querySelectorAll('.category_group,.hide_block');
		if (category_group_hidden_new.length == 1) {
			this.classList.toggle('d-none');
		}
	});
});