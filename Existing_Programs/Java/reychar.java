import java.util.Scanner;
public class reychar
{
    public static void main(String[] args)
    {
        String st, st1 = "", st2 = "";
        char chr;
        Scanner sc = new Scanner(System.in);
        System.out.print("Enter a string: ");
        st = sc.nextLine() + " ";\
        for (int i = 0; i < st.length(); i++)
        {
            chr = st.charAt(i);
            if (chr == ' ')
            {
                st2 = st2 + st1 + " ";
                st1 = "";
            }
            else
            {
                st1 = chr + st1;
            }
        }
        System.out.println("The Output:");
        System.out.print(st2.trim());
    }
}
