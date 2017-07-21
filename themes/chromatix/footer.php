			</section> <!-- page_content_wrapper -->
			<footer class="footer">
				<?php 
					$newsletter_content = get_field( 'newsletter_content', 'options' ); 
					if($newsletter_content)
					{
				?>
						<section class="newsletter_section">
							<div class="newsletter_content content_container clearfix">
								<?php  
									echo $newsletter_content;
								?>
							</div>
						</section>
				<?php
					}
				?>
				<section class="top" data-scroll="contact">
					<div class="top_content content_container clearfix">
						<div class="left_col">
							<div class="footer_logo">
								<a href="<?php echo esc_url(home_url()); ?>" class="link">
									<img
										src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo.png"
										alt="<?php bloginfo("name"); ?>"
										title="<?php bloginfo("name"); ?>"
									/>
								</a>
							</div>
						<?php

							//Contact Details
							$phone = get_field('contact_phone', 'options');
							$email = get_field( 'contact_email', 'options' );
						?>
							<dl class="contact_list">
								<?php 
									if($phone)
									{
								 ?>
										<dt class="icon">
											<?php 
												$path = __DIR__."/images/icons/phone.svg";
												SVGee::render($path); 
											?>
										</dt>
										<dd class="value">
											<a href="tel:<?php echo $phone; ?>">
												<?php echo $phone; ?>
											</a>
										</dd>
								<?php
									}

									if($email)
									{
								 ?>
										<dt class="icon">
											<?php 
												$path = __DIR__."/images/icons/email.svg";
												SVGee::render($path); 
											?>
										</dt>
										<dd class="value">
											<a href="mailto:<?php echo $email; ?>">
												<?php echo $email; ?>
											</a>
										</dd>
								<?php
									}
								?>
							</dl>
							<?php  
								if(have_rows('contact_address', 'options'))
								{
							?>
									<div class="address_wrap">
										<div class="icon">
											<?php 
												$path = __DIR__."/images/icons/location.svg";
												SVGee::render($path); 
											?>
										</div>
										<?php
											while(have_rows('contact_address', 'options'))
											{
												the_row();
												$title = get_sub_field( 'address_title' );
												$address = get_sub_field( 'address' );

												if($title && $address)
												{
										?>
													<div class="address_item">
														<div class="title"><?php echo $title; ?></div>
														<div class="address"><?php echo $address; ?></div>
													</div>
										<?php
												}
											}

										?>
									</div>

							<?php
								}
							?>
						</div>
						<div class="right_col clearfix">
							<?php  
								//Menu Column One
								$menu_heading_one = get_field( 'footer_menu_heading_one', 'options' );

								if($menu_heading_one && has_nav_menu('footer_menu_1'))
								{
							?>
									<div class="menu_col first_col">
										<h4 class="menu_heading">
											<?php echo $menu_heading_one; ?>
										</h4>
										<?php  
											wp_nav_menu(array(
												"theme_location"=>"footer_menu_1",
												"depth"=>0, 
												"link_before"=>"<span class='link'>",
												"link_after"=>"</span>"
											));
										?>
									</div>
							<?php
								}

								//Menu Column Two
								$menu_heading_two = get_field( 'footer_menu_heading_two', 'options' );

								if($menu_heading_two && has_nav_menu('footer_menu_2'))
								{
							?>
									<div class="menu_col second_col">
										<h4 class="menu_heading">
											<?php echo $menu_heading_two; ?>
										</h4>
										<?php  
											wp_nav_menu(array(
												"theme_location"=>"footer_menu_2",
												"depth"=>0, 
												"link_before"=>"<span class='link'>",
												"link_after"=>"</span>"
											));
										?>
									</div>
							<?php
								}

								//Menu Column Three
								$menu_heading_three = get_field( 'footer_menu_heading_three', 'options' );

								if($menu_heading_three && has_nav_menu('footer_menu_3'))
								{
							?>
									<div class="menu_col third_col">
										<h4 class="menu_heading">
											<?php echo $menu_heading_three; ?>
										</h4>
										<?php  
											wp_nav_menu(array(
												"theme_location"=>"footer_menu_3",
												"depth"=>0, 
												"link_before"=>"<span class='link'>",
												"link_after"=>"</span>"
											));
										?>
									</div>
							<?php
								}

								//Fourth column
								$fourth_col_heading = get_field( 'footer_heading_four', 'options' );
								$fourth_col_image = get_field( 'fourth_column_image', 'options' );

								if($fourth_col_heading && $fourth_col_image)
								{
							?>
									<div class="menu_col fourth_col">
										<h4 class="menu_heading">
											<?php echo $fourth_col_heading; ?>
										</h4>
										<?php  
											echo acf_image($fourth_col_image, '', 'made_for_image');
										?>
									</div>
							<?php
								}
							?>
						</div>
					</div>
				</section>
				<section class="bottom">
					<div class="bottom_content content_container clearfix">
						<div class="copyright">
							<?php  
								$company = get_field('company_name', 'options');	
								
								if($company)
								{
							?>
									<span>&copy; Copyright <?php echo date("Y") . ' ' . $company; ?></span>
							<?php 
								}
								else
								{
							?>
									<span>&copy; Copyright <?php echo date("Y"); ?></span>
							<?php
								}

								$terms_link = get_field( 'terms_link', 'options' );
								$terms_text = get_field( 'terms_text', 'options' );
								if($terms_link && $terms_text)
								{
							?>
									<span class="pipe">|</span>
									<a href="<?php echo $terms_link; ?>" title="<?php echo $terms_text; ?>" target="_blank" class="terms_conditions">
										<?php echo $terms_text; ?>
									</a>
							<?php	
								}
							?>
						</div>
						<a href="http://chromatix.com.au" target="_blank" class="chr_link">Chromatix Digital Agency</a>
					</div>
				</section>
			</footer>	
		</div> <!-- chr_content -->	
	</div> <!--chr_page-->
		<?php wp_footer(); ?>
		
	</body>

</html>