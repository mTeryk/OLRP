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
      ExternalLink      = components.ExternalLink;



  //var MediaUpload = wp.editor.MediaUpload;

  var iconEl = el('svg', { width: 24, height: 24 },
      el('path', { fill:'#212120', d:'M9.1,0.2H1.7c-0.8,0-1.5,0.7-1.5,1.5V9c0,0.8,0.7,1.5,1.5,1.5H9c0.8,0,1.5-0.7,1.5-1.5V1.7\n' +
            '\t\tC10.5,0.9,9.9,0.2,9.1,0.2z M9.1,9.1H1.7V1.7H9v7.4H9.1z' } ),
      el('path', { fill:'#212120', d:'M22.3,0.2H15c-0.8,0-1.5,0.7-1.5,1.5V9c0,0.8,0.7,1.5,1.5,1.5h7.3c0.8,0,1.5-0.7,1.5-1.5V1.7\n' +
            '\t\tC23.8,0.9,23.1,0.2,22.3,0.2z M22.3,9.1H15V1.7h7.3V9.1z' } ),
      el('path', { fill:'#212120', d:'M22.3,13.5H15c-0.8,0-1.5,0.7-1.5,1.5v7.3c0,0.8,0.7,1.5,1.5,1.5h7.3c0.8,0,1.5-0.7,1.5-1.5V15\n' +
            '\t\tC23.8,14.1,23.1,13.5,22.3,13.5z M22.3,22.3H15V15h7.3V22.3z' } ),
      el('path', { fill:'#212120', d:'M9.1,13.5H1.7c-0.8,0-1.5,0.7-1.5,1.5v7.3c0,0.8,0.7,1.5,1.5,1.5H9c0.8,0,1.5-0.7,1.5-1.5V15\n' +
            '\t\tC10.5,14.1,9.9,13.5,9.1,13.5z M9.1,22.3H1.7V15H9v7.3H9.1z' } )
  );

  registerBlockType('codeboxr/cbxwpbookmark-postgrid-block', {
    title: cbxwpbookmark_postgrid_block.block_title,
    icon: iconEl,
    category: cbxwpbookmark_postgrid_block.block_category,

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
          block: 'codeboxr/cbxwpbookmark-postgrid-block',
          attributes: props.attributes
        }),

        el(InspectorControls, {},
            // 1st Panel – Form Settings
            el(PanelBody, {title: cbxwpbookmark_postgrid_block.general_settings.heading, initialOpen: true},
                el(TextControl, {
                  label: cbxwpbookmark_postgrid_block.general_settings.title,
                  onChange: (value) => {
                    props.setAttributes({
                      title: value
                    });
                  },
                  value: props.attributes.title
                }),
                el('p', {'class': 'cbxwpbookmark_block_note'}, cbxwpbookmark_postgrid_block.general_settings.title_desc),
                el(SelectControl, {
                  label: cbxwpbookmark_postgrid_block.general_settings.order,
                  options: cbxwpbookmark_postgrid_block.general_settings.order_options,
                  onChange: (value) => {
                    props.setAttributes({
                      order: value
                    });
                  },
                  value: props.attributes.order
                }),
                el(SelectControl, {
                  label: cbxwpbookmark_postgrid_block.general_settings.orderby,
                  options: cbxwpbookmark_postgrid_block.general_settings.orderby_options,
                  onChange: (value) => {
                    props.setAttributes({
                      orderby: value
                    });
                  },
                  value: props.attributes.orderby
                }),
                el(SelectControl, {
                  label: cbxwpbookmark_postgrid_block.general_settings.type,
                  options: cbxwpbookmark_postgrid_block.general_settings.type_options,
                  onChange: (value) => {
                    props.setAttributes({
                      type: value
                    });
                  },
                  multiple: true,
                  value: props.attributes.type
                }),
                el(TextControl, {
                  label: cbxwpbookmark_postgrid_block.general_settings.limit,
                  onChange: (value) => {
                    props.setAttributes({
                      limit: value
                    });
                  },
                  value: props.attributes.limit,
                }),
                el(TextControl, {
                  label: cbxwpbookmark_postgrid_block.general_settings.catid,
                  onChange: (value) => {
                    props.setAttributes({
                      catid: value
                    });
                  },
                  value: props.attributes.catid
                }),
                el('p', {'class': 'cbxwpbookmark_block_note'}, cbxwpbookmark_postgrid_block.general_settings.catid_note),
                el(ToggleControl,
                    {
                      label: cbxwpbookmark_postgrid_block.general_settings.loadmore,
                      onChange: (value) => {
                        props.setAttributes({loadmore: value});
                      },
                      checked: props.attributes.loadmore
                    }
                ),
                el(ToggleControl,
                    {
                      label: cbxwpbookmark_postgrid_block.general_settings.cattitle,
                      onChange: (value) => {
                        props.setAttributes({cattitle: value});
                      },
                      checked: props.attributes.cattitle
                    }
                ),
                el(ToggleControl,
                    {
                      label: cbxwpbookmark_postgrid_block.general_settings.catcount,
                      onChange: (value) => {
                        props.setAttributes({catcount: value});
                      },
                      checked: props.attributes.catcount
                    }
                ),
                el(ToggleControl,
                    {
                      label: cbxwpbookmark_postgrid_block.general_settings.allowdelete,
                      onChange: (value) => {
                        props.setAttributes({allowdelete: value});
                      },
                      checked: props.attributes.allowdelete
                    }
                ),
                el(ToggleControl,
                    {
                        label: cbxwpbookmark_postgrid_block.general_settings.allowdeleteall,
                        onChange: (value) => {
                            props.setAttributes({allowdeleteall: value});
                        },
                        checked: props.attributes.allowdeleteall
                    }
                ),
                el(ToggleControl,
                    {
                      label: cbxwpbookmark_postgrid_block.general_settings.show_thumb,
                      onChange: (value) => {
                        props.setAttributes({show_thumb: value});
                      },
                      checked: props.attributes.show_thumb,
                    }
                )
            )
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
    window.wp.editor
));