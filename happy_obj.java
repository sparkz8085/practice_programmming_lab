import java.util.*;
public class happy_obj
{
	int temp, num, sum, val;
	happy_obj()
	{
		num=0;
	}
    void get_data()
    {
        Scanner sc=new Scanner(System.in);
        System.out.print("Enter a number : ");
        num = sc.nextInt();
        temp = num;
    }
    void func_data()
    {
    	while (num > 9) 
        {
            val = num;
            sum = 0;
            while (val != 0) 
            {
                sum=sum+(val%10);
                val=val/10;
            }
            num=sum;
        }
    }
    void out_data()
    {
    	if (num==1) 
        {
            System.out.printf(temp+" is a Happy Number ");
        }
         else 
        {
            System.out.printf(temp+"is not a Happy Number ");
    	}
    }
    public static void main(String args[]) 
    {  
        happy_obj xyz=new happy_obj();
        xyz.get_data();
        xyz.func_data();
        xyz.out_data();
    }
}
