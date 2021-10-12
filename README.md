Whencord for Alfred
=================
Takes a time string and converts it to a dynamic timestamp for sharing in Discord.

![demo]

Download
--------

Download the latest release [here][release].

**Note:** Written for Alfred 4+. Requires nodeJS to be installed.

### Install NodeJS (if you don't already have it)

If you don't already have nodeJS installed, you'll need it to use Whencord. This is because Whencord uses moment.js (the
same package Discord itself uses). I originally wrote Whencord using a similar PHP package but the relative time and
localisation was not a close enough match. I could then have written the whole thing in NodeJS of course, but then we'd
miss out on PHP's wonderful string to time conversion.

**TL;DR**: Install nodeJS. I'd generally recommend installing [Homebrew][homebrew]. Then it's as simple as opening the
terminal and running:

```
brew install nodejs
```

**MacOS Monterey beta users:** Some stock packages have been removed from MacOS Monterey; this includes php. If you are
using MacOS Monterey, I'd generally recommend installing [Homebrew][homebrew]. Then it's as simple
as: `brew install php`.

Usage
-----

- `wc <datetime>` — Convert a human readable time ([PHP DateTime][datetime]) to a dynamic timestamp
- `wc :<unix timestamp>`
- `⌘t` — Quickly launch from Discord (Discord application must be the front most window)
    - uses text selection within Discord (if text is selected)

Choose a time format from the resulting list. The dynamic timestamp is copied to your clipboard and pasted into the
front most application in MacOS.

Some usage examples:

- `wc tomorrow 2pm`
- `wc today at 8pm`*
- `wc 9.30pm` (today at 9.30pm)
- `wc next Thursday 13:30`
- `wc third weds June 2023` (the third Wednesday of June 2023)
- `2021-02-23 14:00`
- `2021-02-23 2pm` (same as the above)
- `2021-08-15 23:40:44.720305+00:00`
- `wc 3pm pdt` (15:00 in the PDT timezone)
- `+9 hours` (9 hours from now)
- `+2 hours 20 mins` (2 hours and 20 minutes from now)
- `wc :1640433600` (unix timestamp)

For more examples of supported time strings and how to construct them, see the tables shown on the following pages
for [relative][formats-relative], [time][formats-time], [date][formats-date], and [compound][formats-compound] formats.

\* Strictly speaking, the word `at` (e.g. `tomorrow at 2pm`) is not supported, but I decided to help by filtering this out
of any input.

Configuration
-------------

There are only three variables in the workflow's [configuration sheet][config-sheet]; these are set automatically when
you first run Whencord. You should not need to configure anything, but these options can be customised if you wish.

|     Option      |                                                                    Meaning                                                                                                                        |
|-----------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `locale`        | This variable is auto-created to match your main system language, but can manually be set to [any locale supported by moment.js][mjslocales].                                                     |
| `nodePath`      | This variable is auto-created to match the path to your nodejs binary, but can manually be set if you wish to use a different bin (e.g. `/usr/local/bin/node` or wherever you have it installed.) |
| `localTimezone` | For local time, use a different [timezone][timezones] than your system clock. If left blank, your system timezone will be used automatically.                                                     |

License
----------------------

Alfred-Whencord is released under the [MIT Licence][mit].

Attribution
----------------------

Credit to [DJDavid98's HammerTime](https://github.com/DJDavid98/HammerTime), which inspired me to bring the concept to
an Alfred workflow.

- [Moment.js][mjs]

[mit]: http://opensource.org/licenses/MIT
[release]: https://github.com/HilbertGilbertson/alfred-whencord/releases/latest
[demo]: https://raw.githubusercontent.com/HilbertGilbertson/alfred-whencord/master/demo.gif
[datetime]: https://www.php.net/manual/en/datetime.formats.php
[formats-time]: https://www.php.net/manual/en/datetime.formats.time.php
[formats-date]: https://www.php.net/manual/en/datetime.formats.date.php
[formats-compound]: https://www.php.net/manual/en/datetime.formats.compound.php
[formats-relative]: https://www.php.net/manual/en/datetime.formats.relative.php
[timezones]: https://www.php.net/manual/en/timezones.php
[config-sheet]: https://www.alfredapp.com/help/workflows/advanced/variables/#environment
[homebrew]: https://brew.sh
[mjslocales]: https://github.com/moment/moment/tree/develop/locale
[mjs]: https://github.com/moment/moment
