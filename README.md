# Seat QQ Connector  
[中文文档](https://github.com/FeiBam/seat-qq-connector/blob/master/docs/README_zh.md)

A [SeAT](https://github.com/eveseat/seat) plugin which Link seat user to QQ number to help you find SPY in the group

[![Latest Unstable Version](https://poser.pugx.org/warlof/seat-discord-connector/v/unstable)](https://packagist.org/packages/warlof/seat-discord-connector)
[![Latest Stable Version](https://poser.pugx.org/warlof/seat-discord-connector/v/stable)](https://packagist.org/packages/warlof/seat-discord-connector)
[![Maintainability](https://api.codeclimate.com/v1/badges/311526bc5675980c66e8/maintainability)](https://codeclimate.com/github/zenobio93/seat-discord-connector/maintainability)
[![License](https://img.shields.io/badge/license-GPLv3-blue.svg?style=flat-square)](https://raw.githubusercontent.com/zenobio93/seat-discord-connector/master/LICENSE)


Thanks to [Warlof Tutsimo](https://github.com/warlof) for Provide Library Packages.  

## Setup


Please make sure to visit https://seat.example.com/seat-connector/settings and click the 'Save' button under the QQ settings the first time you use it. The button should appear green.

## Notice!

Since the official QQ service does not provide an OAuth2 API for anything other than retrieving the username, and there is no official bot implementation, you may need to manually search for users at https://seat.example.com/seat-connector/users, then grant them permissions or delete them form you group!

## Upgrade

If you're coming from a version prior to 4.x, you may want to convert your data into the new connector structure.
To do so, run the command `seat-connector:convert:qq` - it will assist you in this process.

