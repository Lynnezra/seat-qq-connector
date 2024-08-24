# Seat QQ Connector  

这是个 [SeAT](https://github.com/eveseat/seat) QQ和 SeAT 用户绑定的插件，帮助您找出潜伏在群内并且没有递交seat的SPY。

[![Latest Unstable Version](https://poser.pugx.org/warlof/seat-discord-connector/v/unstable)](https://packagist.org/packages/warlof/seat-discord-connector)
[![Latest Stable Version](https://poser.pugx.org/warlof/seat-discord-connector/v/stable)](https://packagist.org/packages/warlof/seat-discord-connector)
[![Maintainability](https://api.codeclimate.com/v1/badges/311526bc5675980c66e8/maintainability)](https://codeclimate.com/github/zenobio93/seat-discord-connector/maintainability)
[![License](https://img.shields.io/badge/license-GPLv3-blue.svg?style=flat-square)](https://raw.githubusercontent.com/zenobio93/seat-discord-connector/master/LICENSE)


感谢 [Warlof Tutsimo](https://github.com/warlof) 提供底层依赖库.

---  
## 第一次使用

在您第一次使用之前，请务必访问 https://seat.example.com/seat-connector/settings ，设置页面。
并且点击一次位于QQ设置下方的保存按钮，他看起来应该是绿色。

## Notice!

因为QQ 官方没有提供任何除了获取用户名之外的OAuth2.0 API 所以 你可能需要访问 https://seat.example.com/seat-connector/users
切换到QQ 手动检索用户并且从群里移除他们。

## Upgrade

如果您使用的是 4.x 之前的版本，您可能需要将老连接器数据结构转换为新的连接器数据结构。
请运行命令“seat-connector:convert:qq” - 它将帮助您完成此过程。

