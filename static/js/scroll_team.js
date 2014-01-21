$(function() {

				//	Responsive layout, resizing the items
				$('#foo4').carouFredSel({
					responsive: true,
					width: '100%',
					auto: false,
					prev: '#prev3',
					next: '#next3',
					swipe: {
						onMouse: true,
						onTouch: true
					},
					items: {
						width: 350,
					//	height: '30%',	//	optionally resize item-height
						visible: {
							min: 1,
							max: 3
						}
					}
				});

				
			});