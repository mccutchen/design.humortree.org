import string

"""
# Lighter Colors

blue_dark = '#0056A7'
blue_medium = '#80ABD3'
blue_light = '#BFD5E9'

red_dark = '#F04E31'
red_medium = '#F8A798'
red_light = '#FCD3CC'

gold_dark = '#FCB23D'
gold_medium = '#FED99E'
gold_light = '#FFECCF'
"""

# Darker Colors

blue_dark = '#10167F'
blue_medium = '#888BBF'
blue_light = '#C4C5DF'

red_dark = '#FE230A'
red_medium = '#FF9185'
red_light = '#FFC8C2'

gold_dark = '#FF9600'
gold_medium = '#FFCB80'
gold_light = '#FFE5C0'

template = file('colors.css.tmpl')
output = template.read()

output = output.replace('$blue_dark$', blue_dark)
output = output.replace('$blue_medium$', blue_medium)
output = output.replace('$blue_light$', blue_light)

output = output.replace('$red_dark$', red_dark)
output = output.replace('$red_medium$', red_medium)
output = output.replace('$red_light$', red_light)

output = output.replace('$gold_dark$', gold_dark)
output = output.replace('$gold_medium$', gold_medium)
output = output.replace('$gold_light$', gold_light)

print output







