function translate (value, __ = wp.i18n.__, textdomain = 'oceanwp') {
    return __(value, textdomain)
}

function capitalize(value) {
    return `${value[0]}${value.slice(1)}`
}

function createSection (section, index) {
    const customizeAction = `Customizing ▸ ${section.title}`
    const options = { title: section.title, priority: (index + 1) * 10, panel: 'ocean_general_panel', customizeAction }
    return new this.Section(section.name, options)
}

function panel (wpCustomize) {
    const panel = new wpCustomize.Panel('ocean_general_panel', { title: translate('General Options'), priority: 210 })
    return wpCustomize.panel.add(panel)
}

function sections (wpCustomize) {
    const sections = [
        { name: 'ocean_general_styling', title: 'General Styling' }
    ]
    return sections.map(createSection.bind(wpCustomize)).map(section => wpCustomize.section.add(section))
}

function stylingControls(wpCustomize) {
    const colorControls = ['ocean_primary_color', 'ocean_hover_primary_color', 'ocean_main_border_color', 'ocean_background_color']
    const controls = [
        wpCustomize.control.add(
            new wpCustomize.Control('ocean_customzer_styling', {
                label: translate('Styling Options Location'),
                description: translate('If you choose Custom File, a CSS file will be created in your uploads folder.'),
                settings: { default: 'ocean_customzer_styling' },
                type: 'radio',
                section: 'ocean_general_styling',
                label: 'Check this box to do something.',
                choices: { head: translate('WP Head'), file: translate('Custom File') }
            })
        ),
        // wpCustomize.control.add(
        //     new wpCustomize.OceanWP_Customizer_Heading_Control('ocean_site_background_heading', {
        //         label: translate('Site Background'),
        //         section: 'ocean_general_styling',
        //         settings: { default: 'ocean_site_background_heading' }
        //     })
        // ),
        ...colorControls.map(control => wpCustomize.control.add(
            new wpCustomize.OceanWPCustomizerColorControl(control, {
                type:  'alpha-color',
                label: translate(control.split('_').slice(1).map(capitalize).join(' ')),
                section: 'ocean_general_styling',
                settings: { default: control }
            })
        )),
        wpCustomize.control.add(
            new wpCustomize.ImageControl('ocean_background_image', {
                label: translate('Background Image'),
                section: 'ocean_general_styling',
                settings: { default: 'ocean_background_image' }
            })
        ),
        wpCustomize.control.add(
            new wpCustomize.Control('ocean_background_image_position', {
                label: translate('Position'),
                settings: { default: 'ocean_background_image_position' },
                type: 'select',
                section: 'ocean_general_styling',
                label: 'Check this box to do something.',
                choices: {
					initial: translate('Default'),
					'top left': translate('Top Left'),
					'top center': translate('Top Center'),
					'top right': translate('Top Right'),
					'center left': translate('Center Left'),
					'center center': translate('Center Center'),
					'center right': translate('Center Right'),
					'bottom left': translate('Bottom Left'),
					'bottom center': translate('Bottom Center'),
					'bottom right': translate('Bottom Right'),
                }
            })
        ),
    ];

    return controls
}

function controls(wpCustomize) {
    stylingControls(wpCustomize)
}

function generalControls(wp) {
    const { customize: wpCustomize } = wp
    panel(wpCustomize)
    sections(wpCustomize)
    controls(wpCustomize)
    console.log(new wpCustomize.ImageControl('', {}))
}

wp.customize.bind('ready', generalControls.bind(null, wp))
