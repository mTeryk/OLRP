'use strict';

(function(blocks, element, components, editor, $) {
  var el                = element.createElement,
      registerBlockType = blocks.registerBlockType,
      InspectorControls = editor.InspectorControls,
      ServerSideRender  = components.ServerSideRender,
      RangeControl      = components.RangeControl,
      Panel             = components.Panel,
      PanelBody         = components.PanelBody,
      PanelRow          = components.PanelRow,
      TextControl       = components.TextControl,
      //NumberControl = components.NumberControl,
      TextareaControl   = components.TextareaControl,
      CheckboxControl   = components.CheckboxControl,
      RadioControl      = components.RadioControl,
      SelectControl     = components.SelectControl,
      ToggleControl     = components.ToggleControl,
      //ColorPicker = components.ColorPalette,
      //ColorPicker = components.ColorPicker,
      //ColorPicker = components.ColorIndicator,
      PanelColorPicker  = editor.PanelColorSettings,
      DateTimePicker    = components.DateTimePicker,
      HorizontalRule    = components.HorizontalRule,
      ExternalLink      = components.ExternalLink,
      Icon              = components.Icon;



  //var MediaUpload = wp.editor.MediaUpload;

  //icon custom created, see stored image
  var iconEl = el('svg', {width: 24, height: 24},
      el('path', {fill:"#212121", d: 'M1.6,0.2H9c0.8,0,1.5,0.7,1.5,1.5V9c0,0.8-0.7,1.5-1.5,1.5H1.6c-0.8,0-1.5-0.7-1.5-1.5V1.6\n' +
            '\t\tC0.2,0.8,0.8,0.2,1.6,0.2z M1.6,9H9V1.6H1.6V9z'}),
      el('path', {fill:"#212121", d: 'M15,0.2h7.4c0.8,0,1.5,0.7,1.5,1.5V9c0,0.8-0.7,1.5-1.5,1.5H15c-0.8,0-1.5-0.7-1.5-1.5V1.6\n' +
            '\t\tC13.5,0.8,14.1,0.2,15,0.2z M15,9h7.4V1.6H15V9z'}),
      el('path', {fill:"#212121", d: 'M1.6,13.5H9c0.8,0,1.5,0.7,1.5,1.5v7.4c0,0.8-0.7,1.5-1.5,1.5H1.6c-0.8,0-1.5-0.7-1.5-1.5V15\n' +
            '\t\tC0.2,14.1,0.8,13.5,1.6,13.5z M1.6,22.4H9V15H1.6V22.4z'}),
      el('path', {fill:"#212121", d: 'M13.5,14.6c0-0.6,0.5-1,1-1h8.2c0.6,0,1,0.5,1,1v8.2c0,0.6-0.5,1-1,1h-8.2c-0.6,0-1-0.5-1-1V14.6z'}),
      el('path', {fill:"#FFFFFF", d: 'M20.8,20.8h2.1v-6.2h-8.2v6.2h2.1c0,0.6,0.5,1,1,1h2.1C20.3,21.8,20.8,21.3,20.8,20.8z'}),
      el('polygon', {fill:"#212121", points: '18.2,17.7 18.2,16.1 19.2,16.1 19.2,17.7 20.8,17.7 18.7,19.7 16.6,17.7 \t\t'}),
  );




  registerBlockType('codeboxr/cbxwpbookmark-mostdownloads-block', {
    title: cbxwpbookmark_mostdownloads_block.block_title,
    icon: iconEl,
    category: cbxwpbookmark_mostdownloads_block.block_category,

    /*
     * In most other blocks, you'd see an 'attributes' property being defined here.
     * We've defined attributes in the PHP, that information is automatically sent
     * to the block editor, so we don't need to redefine it here.
     */
    edit: function(props) {

      return [
        /*
         * The ServerSideRender element uses the REST API to automatically call
         * php_block_render() in your PHP code whenever it needs to get an updated
         * view of the block.
         */
        el(ServerSideRender, {
          block: 'codeboxr/cbxwpbookmark-mostdownloads-block',
          attributes: props.attributes,
        }),

        el(InspectorControls, {},
            el(PanelBody, {title: cbxwpbookmark_mostdownloads_block.general_settings.heading, initialOpen: true},
                el(TextControl, {
                  label: cbxwpbookmark_mostdownloads_block.general_settings.title,
                  onChange: (value) => {
                    props.setAttributes({
                      title: value,
                    });
                  },
                  value: props.attributes.title,
                }),
                el('p', {'class': 'cbxwpbookmark_block_note'}, cbxwpbookmark_mostdownloads_block.general_settings.title_desc),
                el(SelectControl, {
                  label: cbxwpbookmark_mostdownloads_block.general_settings.order,
                  options: cbxwpbookmark_mostdownloads_block.general_settings.order_options,
                  onChange: (value) => {
                    props.setAttributes({
                      order: value,
                    });
                  },
                  value: props.attributes.order,
                }),
                el(SelectControl, {
                  label: cbxwpbookmark_mostdownloads_block.general_settings.orderby,
                  options: cbxwpbookmark_mostdownloads_block.general_settings.orderby_options,
                  onChange: (value) => {
                    props.setAttributes({
                      orderby: value,
                    });
                  },
                  value: props.attributes.orderby,
                }),
                el(SelectControl, {
                  label: cbxwpbookmark_mostdownloads_block.general_settings.type,
                  options: cbxwpbookmark_mostdownloads_block.general_settings.type_options,
                  onChange: (value) => {
                    props.setAttributes({
                      type: value,
                    });
                  },
                  multiple: true,
                  value: props.attributes.type,
                }),
                el(TextControl, {
                  label: cbxwpbookmark_mostdownloads_block.general_settings.limit,
                  onChange: (value) => {
                    props.setAttributes({
                      limit: value,
                    });
                  },
                  value: props.attributes.limit,
                }),
                el(SelectControl, {
                  label: cbxwpbookmark_mostdownloads_block.general_settings.daytime,
                  options: cbxwpbookmark_mostdownloads_block.general_settings.daytime_options,
                  onChange: (value) => {
                    props.setAttributes({
                      daytime: value
                    });
                  },
                  value: props.attributes.daytime
                }),
                el(ToggleControl,
                    {
                      label: cbxwpbookmark_mostdownloads_block.general_settings.show_count,
                      onChange: (value) => {
                        props.setAttributes({show_count: value});
                      },
                      checked: props.attributes.show_count,
                    },
                ),
                el(ToggleControl,
                    {
                      label: cbxwpbookmark_mostdownloads_block.general_settings.show_thumb,
                      onChange: (value) => {
                        props.setAttributes({show_thumb: value});
                      },
                      checked: props.attributes.show_thumb,
                    },
                ),
                el(ToggleControl,
                    {
                      label: cbxwpbookmark_mostdownloads_block.general_settings.show_price,
                      onChange: (value) => {
                        props.setAttributes({show_price: value});
                      },
                      checked: props.attributes.show_price,
                    },
                ),
                el(ToggleControl,
                    {
                      label: cbxwpbookmark_mostdownloads_block.general_settings.show_addcart,
                      onChange: (value) => {
                        props.setAttributes({show_addcart: value});
                      },
                      checked: props.attributes.show_addcart,
                    },
                ),
            ),
        ),

      ];
    },
    // We're going to be rendering in PHP, so save() can just return null.
    save: function() {
      return null;
    },
  });
}(
    window.wp.blocks,
    window.wp.element,
    window.wp.components,
    window.wp.editor,
));