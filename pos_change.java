import java.util.Scanner;

public class pos_change
{
    public static void main(String[] args) 
    {
        Scanner sc= new Scanner(System.in);
        System.out.println("enter a name for experiment: ");
        String fn = sc.nextLine();
        String ln = sc.nextLine();
        String fln=(ln+' '+fn);
        System.out.print(fln);
    }
}

