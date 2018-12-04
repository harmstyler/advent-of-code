import re

day3File = open(r"input.txt", "r")
day3Inputs = day3File.readlines()
day3File.close()


def parse_input(usr_input):
    guess = re.search('(?<=\#)(.*?)(?=\ )', usr_input)
    x = re.search('(?<=\@ )(.*?)(?=,)', usr_input)
    y = re.search('(?<=\,)(.*?)(?=\:)', usr_input)
    width = re.search('(?<=: )(.*?)(?=x)', usr_input)
    height = re.search('(?<=x)(.*?)(?=$)', usr_input)

    parsed = [guess.group(), x.group(), y.group(), width.group(), height.group()]

    return Claim(parsed)


class Claim:
    def __init__(self, usr_input):
        self.guess = usr_input[0]
        self.x = int(usr_input[1])
        self.y = int(usr_input[2])
        self.width = int(usr_input[3])
        self.height = int(usr_input[4])
        self.map = self.calc_rect()
        self.has_intersect = False

    def calc_rect(self):
        rect_map = []
        for x in range(self.x, self.x + self.width):
            for y in range(self.y, self.y + self.height):
                rect_map.append(str(x) + ',' + str(y))
        return rect_map


def intersection(lst1, lst2):
    return list(set(lst1) & set(lst2))


claims = []

print("Building maps...")
for day3Input in day3Inputs:
    claims.append(parse_input(day3Input.rstrip()))

intersections = []

print("Calculating intersections...")
for i in range(len(claims)):
    print("Calculating intersection " + str(i) + " of " + str(len(claims)))
    for claim in claims:
        if claims[i].guess == claim.guess:
            continue

        found_intersections = intersection(claims[i].map, claim.map)
        if len(found_intersections):
            claims[i].has_intersect = True
            intersections = intersections + found_intersections
        if i % 100 == 0:
            intersections = list(set(intersections))

print("Found Intersections Length:")
print(len(set(intersections)))

for claim in claims:
    if not claim.has_intersect:
        print("Guess " + claim.guess + " has no intersections")
        break
