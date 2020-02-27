			//在线预测服务的功能
			$('#predict-action').on('click',function(){
				post_data = {};
				post_data['id']=$('input[name="disease"]').attr('attr-id');
				post_data['genes'] = $('#textarea1').val();
				$.ajax({
					type:"post",
					url:"/predict_script/predict.php",
					async:true,
					data:post_data,
					beforeSend:function(){
						index=layer.load(0, {shade: false});
					},
					success:function(res){
						layer.close(index);
						if (res.status == 1) {
							$('#df-result').text(res.drugFitness);
							$('.result-card').css('display','block');
						} else{
							dialog.error(res.message);
						}
					},
					dataType:'json'
				});			
			});
			
			//批量预测按钮的操作
			$('#batch-predict').on('click',function(){				
				var form = new FormData(document.getElementById('batch-form'));
				$.ajax({
					type:"post",
					url:"/predict_script/batch_predict.php",
					async:true,
					cache:false,
					processData: false,  
      				contentType: false,
					data:form,
					beforeSend:function(){
						i=layer.load(0, {shade: false});
					},
					success:function(res){
						layer.close(i);
						if (res.status == 1) {
							dialog.success(res.message,'/batch.php');
						} else{
							dialog.error(res.message);
						}
					},
					dataType:'json'
				});
			});
