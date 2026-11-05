import java.util.Scanner;
public class abbriviation
{
    public static void main(String args[])
    {
        String name, fw = "";
        int i;
        char chr;
        Scanner sc = new Scanner(System.in);
        System.out.print("enter a name: ");
        name = sc.nextLine();
        fw = name.charAt(0) + ".";
        for (i = 0; i < name.length(); i++)
        {
            chr= name.charAt(i);
            if (chr == ' ')
            {
                fw = fw + name.charAt(i + 1) + ".";
            }
        }
        System.out.print("abbreviation: ");
        System.out.println(fw);
    }
}

