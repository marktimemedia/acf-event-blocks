( function(wp) {

	var registerBlockType = wp.blocks.registerBlockType;
	var InspectorControls = wp.editor.InspectorControls;
	var TextControl = wp.components.TextControl;
	var SelectControl = wp.components.SelectControl;
	var CheckboxControl = wp.components.CheckboxControl;
	var withState = wp.compose.withState;
	var el = wp.element.createElement;
	var ServerSideRender = wp.components.ServerSideRender;
	var DatePicker = wp.components.DatePicker;
	var __ = wp.i18n.__;

	function acfes_dateFormatted(date){
		if(date === null){
			var date = moment().format("YYYY-MM-DD");
		} else {
			var date = moment(date).format("YYYY-MM-DD");
		}
		return date;
	}

	registerBlockType( 'acfes/schedule-block', {
		title: 'Conference Schedule',
		icon: 'schedule',
		category: 'acfes-event-blocks',
		supports: {
			align: true,
			align: ['wide']
		},
		attributes: {
			date: {type: 'string', default: acfes_dateFormatted(null)},
			color_scheme: {type: 'string', default: 'light'},
			schedule_layout: {type: 'string', default: 'table'},
			session_link: {type: 'string', default: 'permalink'},
			speaker_link: {type: 'string', default: 'permalink'}
		},

		edit: function( props ) {
			var attributes = props.attributes;
			var setAttributes = props.setAttributes;

			var date = props.attributes.date;
			var color_scheme = props.attributes.color_scheme;
			var schedule_layout = props.attributes.schedule_layout;
			var session_link = props.attributes.session_link;
			var speaker_link = props.attributes.speaker_link;

			return [
				el(ServerSideRender, {
						block: "acfes/schedule-block",
						attributes: props.attributes
				}),
				el(InspectorControls, {},
					el(DatePicker, {
							currentDate : date,
							locale: 'en',
							selected: date,
							onChange: function(value){
								setAttributes({date: acfes_dateFormatted(value)});
							}
					}),
					el(SelectControl, {
						label: 'Color Scheme',
						value: color_scheme,
						options: [
							{value: 'light', label: 'Light'},
							{value: 'dark', label: 'Dark'}
						],
						onChange: function(value){
							setAttributes({color_scheme: value});
						}
					}),
					el(SelectControl, {
						label: 'Schedule Layout',
						value: schedule_layout,
						options: [
							{value: 'table', label: 'Table'},
							{value: 'grid', label: 'Grid'}
						],
						onChange: function(value){
							setAttributes({schedule_layout: value});
						}
					}),
					el(SelectControl, {
						label: 'Session Link',
						value: session_link,
						options: [
							{value: 'permalink', label: 'Permalink'},
							{value: 'anchor', label: 'Anchor'},
							{value: 'none', label: 'None'}
						],
						onChange: function(value){
							setAttributes({session_link: value});
						}
					}),
					el(SelectControl, {
						label: 'Speaker Link',
						value: speaker_link,
						options: [
							{value: 'permalink', label: 'Permalink'},
							{value: 'anchor', label: 'Anchor'},
							{value: 'none', label: 'Hide'}
						],
						onChange: function(value){
							setAttributes({speaker_link: value});
						}
					}),
				),
			];
		},

		save: function(props) {
			return null;
		}

	});
}(window.wp));
