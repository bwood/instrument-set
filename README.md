# Terminus Instrument Set Plugin
[![Actively Maintained](https://img.shields.io/badge/Pantheon-Actively_Maintained-yellow?logo=pantheon&color=FFDC28)](https://pantheon.io/docs/oss-support-levels#actively-maintained-support)

[![Terminus v4.x Compatible](https://img.shields.io/badge/terminus-4.x-green.svg)](https://github.com/pantheon-systems/terminus-plugin-example/tree/2.x)

A plugin to set the Pantheon billing instrument.

Adds commands `instrument:set` to Terminus. Learn more about Terminus Plugins in the

[Terminus Plugins documentation](https://pantheon.io/docs/terminus/plugins)

## Configuration

These commands require no configuration

## Usage
* `terminus instrument:set [UUID of billing instrument]`

## Installation

To install this plugin using Terminus 4:

1. Download the code to ~/.terminus/plugins
2. Run terminus install command:
```
terminus self:plugin:install $HOME/.terminus/plugins/instrument-set
```

## Help
Run `terminus help instrument:set` for help.
