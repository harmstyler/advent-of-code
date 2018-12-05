import re
import dateutil.parser

recordsFile = open(r"input.txt", "r")
records = recordsFile.readlines()
recordsFile.close()


def parse_date(date_string):
    return dateutil.parser.parse(date_string)


def parse_record(record):
    date = re.search('(?<=\[)(.*?)(?=\])', record).group()
    action = re.search('(?<=\] )(.*$)', record).group()

    return {'date': parse_date(date), 'action': action}


def most_common(lst):
    # return mode(lst)
    lst = sorted(lst)
    lst_mode_dict = {}
    prev_num = -1
    for item in lst:
        curr_num = item
        if curr_num != prev_num:
            prev_num = curr_num
            lst_mode_dict.update({prev_num: 1})
        else:
            lst_mode_dict.update({curr_num: (lst_mode_dict.get(curr_num) + 1)})
    mode = max(lst_mode_dict, key=lst_mode_dict.get)

    return {'mode': max(lst_mode_dict, key=lst_mode_dict.get), 'mode_factor': lst_mode_dict.get(mode)}

class Guard:
    def __init__(self, guard_num):
        self.guard_num = guard_num
        self.sleep_minutes = []
        self.sleep_length = 0
        self.sleep_minutes_mode = 0
        self.sleep_minutes_mode_factor = 0

    def add_sleep(self, minutes):
        minutes_dict = list(minutes)
        self.sleep_length += len(minutes_dict)
        self.sleep_minutes = self.sleep_minutes + minutes_dict


records_list = []
guard_dict = {}
minute_start = 0
minute_end = 0

for record in records:
    parsed_record = parse_record(record.rstrip())
    records_list.append(parsed_record)

records_list.sort(key=lambda r: r.get('date'))

for record in records_list:
    action = record.get('action')
    date = record.get('date')
    if action.startswith('Guard'):
        guard_num = re.search('(?<=#)(.*?)(?= )', action).group()
        if guard_num not in guard_dict:
            new_guard = Guard(guard_num)
            guard_dict.update({guard_num: new_guard})
        current_guard = guard_dict.get(guard_num)
        continue

    if action == 'falls asleep':
        minute_start = date.minute
    else:
        minute_end = date.minute
        current_guard.add_sleep(range(minute_start, minute_end))

sleepiest_guard = Guard('Dummy')

for guard_num, guard in guard_dict.items():
    if len(guard.sleep_minutes):
        mode_dict = most_common(guard.sleep_minutes)
        guard.sleep_minutes_mode = mode_dict.get('mode')
        guard.sleep_minutes_mode_factor = mode_dict.get('mode_factor')
    if guard.sleep_length > sleepiest_guard.sleep_length:
        sleepiest_guard = guard

most_consistent_sleeper = Guard('Dummy')
for guard_num, guard in guard_dict.items():
    if guard.sleep_minutes_mode_factor > most_consistent_sleeper.sleep_minutes_mode_factor:
        most_consistent_sleeper = guard


print("The sleepiest guard #" + sleepiest_guard.guard_num)

most_common_minute = sleepiest_guard.sleep_minutes_mode

print("Most Common Minute: " + str(most_common_minute))

print("Part 1: " + str(most_common_minute * int(sleepiest_guard.guard_num)))

print("Part 2: " + str(most_consistent_sleeper.sleep_minutes_mode * int(most_consistent_sleeper.guard_num)))
