import java.util.*;
public class piglatin
{
    public static void main(String[] args)
    {
        String str1, str2;
        int x, y;
        char b;
        Scanner sc = new Scanner(System.in);
        System.out.print("Enter a sentence: ");
        String str = sc.nextLine();
        x = str.length();
        for (y = 0; y < x; y++)
        {
            b = str.charAt(y);
            if (b == 'a' || b == 'e' || b == 'i' || b == 'o' || b == 'u' ||b == 'A' || b == 'E' || b == 'I' || b == 'O' || b == 'U')
            {
                ;
            }
        }
        str1 = str.substring(y);
        str2 = str.substring(0, y);
        System.out.println("The Pig Latin form of the given string:");
        System.out.println(str1 + str2 + "AY");
    }
}
