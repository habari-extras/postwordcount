<?php 

/**********************************
 *
 * Word Count for Posts
 * 
 * usage: <?php echo $post->word_count; ?>
 *
 *********************************/

class PostWordCount extends Plugin
{
	public function help()
	{
		$help = _t( 'To use, <code>&lt;?php echo $post->word_count; ?&gt;</code>.' );
		return $help;
	}

	public function action_update_check()
	{
	 	Update::add( $this->info->name, $this->info->guid, $this->info->version );
	}

        public function filter_plugin_config( $actions, $plugin_id )
        {
                if ( $plugin_id == $this->plugin_id() ) {
                        $actions[]= _t( 'Configure' );
                }
                return $actions;
        }

	public function action_post_update_after( $post )
	{
		$allcharacters = 'ÁÀÂÄǍĂĀÃÅǺĄƁĆĊĈČÇĎḌƊÉÈĖÊËĚĔĒĘẸƎƏƐĠĜǦĞĢƔĤḤĦIÍÌİÎÏǏĬĪĨĮỊĴĶƘĹĻŁĽĿŃŇÑŅÓÒÔÖǑŎŌÕŐỌØǾƠŔŘŖŚŜŠŞȘṢŤŢṬÚÙÛÜǓŬŪŨŰŮŲỤƯẂẀŴẄǷÝỲŶŸȲỸƳŹŻŽẒáàâäǎăāãåǻąɓćċĉčçďḍɗéèėêëěĕēęẹǝəɛġĝǧğģɣĥḥħıíìiîïǐĭīĩįịĵķƙĸĺļłľŀŉńňñņóòôöǒŏōõőọøǿơŕřŗśŝšşșṣſťţṭúùûüǔŭūũűůųụưẃẁŵẅƿýỳŷÿȳỹƴźżžẓΑΆΒΓΔΕΈΖΗΉΘΙΊΪΚΛΜΝΞΟΌΠΡΣΤΥΎΫΦΧΨΩΏαάβγδεέζηήθιίϊΐκλμνξοόπρσςτυύϋΰφχψωώÆǼǢÐĐĲŊŒÞŦæǽǣðđĳŋœßþŧ';
		$post->info->wordcount = str_word_count( strip_tags( ( $this->config[ 'add_title' ] ? $post->content . " {$post->title}" : $post->content ) ), 0, $allcharacters );
		$post->info->commit();
	}
	
        public function action_plugin_ui( $plugin_id, $action )
        {
                if ( $plugin_id == $this->plugin_id() ) {
                        switch ( $action ) {
                                case _t( 'Configure' ):
                                        $class_name= strtolower( get_class( $this ) );
                                        $ui= new FormUI( $class_name );

                                        $add_title= $ui->append( 'checkbox', 'add_title',
                                                $class_name . '__add_title', _t( 'Include title words in count?' ) );

                                        $ui->append( 'submit', 'save', 'save' );
                                        $ui->out();
                                        break;
                        }
                }
        }

	public function action_init()
	{
		$class_name= strtolower( get_class( $this ) );
                $this->config[ 'add_title' ]= Options::get( $class_name . '__add_title' );

	}
	
	public function filter_post_word_count( $word_count, $post ) 
	{
		$allcharacters = 'ÁÀÂÄǍĂĀÃÅǺĄƁĆĊĈČÇĎḌƊÉÈĖÊËĚĔĒĘẸƎƏƐĠĜǦĞĢƔĤḤĦIÍÌİÎÏǏĬĪĨĮỊĴĶƘĹĻŁĽĿŃŇÑŅÓÒÔÖǑŎŌÕŐỌØǾƠŔŘŖŚŜŠŞȘṢŤŢṬÚÙÛÜǓŬŪŨŰŮŲỤƯẂẀŴẄǷÝỲŶŸȲỸƳŹŻŽẒáàâäǎăāãåǻąɓćċĉčçďḍɗéèėêëěĕēęẹǝəɛġĝǧğģɣĥḥħıíìiîïǐĭīĩįịĵķƙĸĺļłľŀŉńňñņóòôöǒŏōõőọøǿơŕřŗśŝšşșṣſťţṭúùûüǔŭūũűůųụưẃẁŵẅƿýỳŷÿȳỹƴźżžẓΑΆΒΓΔΕΈΖΗΉΘΙΊΪΚΛΜΝΞΟΌΠΡΣΤΥΎΫΦΧΨΩΏαάβγδεέζηήθιίϊΐκλμνξοόπρσςτυύϋΰφχψωώÆǼǢÐĐĲŊŒÞŦæǽǣðđĳŋœßþŧ';
		return str_word_count( strip_tags( ( $this->config[ 'add_title' ] ? $post->content . " {$post->title}" : $post->content ) ), 0, $allcharacters ); 	
	}
}
?>
