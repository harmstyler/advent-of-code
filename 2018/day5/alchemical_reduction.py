char_file = open(r"input.txt", "r")
chars = char_file.read()
char_file.close()


class AlchemicalChars:
    def __init__(self, char_list):
        self.char_list = char_list

    def check_reaction(self):
        prev_char = '0'
        for index, char in enumerate(self.char_list):
            if char != prev_char and (char.lower() == prev_char.lower()):
                del self.char_list[index]
                del self.char_list[index - 1]
                break

            prev_char = char

    def refine_chars(self):
        while True:
            prev_char_list = self.char_list.copy()
            self.check_reaction()
            if len(prev_char_list) == len(self.char_list):
                break

        return self.char_list

    def remove_then_refine(self):
        self.char_list = list(filter(lambda a: (a != letter and a != letter.upper()), self.char_list))
        self.refine_chars()

        return self.char_list


char_list = list(chars.rstrip())

# alchemical_chars = AlchemicalChars(char_list)
# alchemical_chars.refine_chars()

# print('Found alchemical chars: ' + str(len(alchemical_chars.char_list)))

letter_refinements = {}
for letter in list(map(chr, range(97, 123))):
    refined_chars = AlchemicalChars(char_list)
    refinements = refined_chars.remove_then_refine()
    letter_refinements.update({letter: len(refinements)})
    print(str(letter) + ' : ' + str(len(refinements)))

